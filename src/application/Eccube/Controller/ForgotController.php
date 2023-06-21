<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Controller;

use Eccube\Controller\Annotation\Template;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Form\Type\Front\ForgotType;
use Eccube\Form\Type\Front\PasswordResetType;
use Eccube\Repository\CustomerRepository;
use Eccube\Routing\Annotation\Route;
use Eccube\Routing\Generator\UrlGeneratorInterface;
use Eccube\Security\Core\User\UserPasswordHasher;
use Eccube\Service\MailService;
use Eccube\Validator\Constraints as Assert;
use Eccube\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception as HttpException;

class ForgotController extends AbstractController
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * ForgotController constructor.
     *
     * @param Validator $validator
     * @param MailService $mailService
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        Validator $validator,
        MailService $mailService,
        CustomerRepository $customerRepository
    ) {
        $this->validator = $validator;
        $this->mailService = $mailService;
        $this->customerRepository = $customerRepository;
    }

    /**
     * パスワードリマインダ.
     *
     * @Route("/forgot", name="forgot", methods={"GET", "POST"})
     * @Template("Forgot/index.twig")
     */
    public function index(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new HttpException\NotFoundHttpException();
        }

        $builder = $this->formFactory
            ->createNamedBuilder('', ForgotType::class);

        $event = new EventArgs(
            [
                'builder' => $builder,
            ],
            $request
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_FORGOT_INDEX_INITIALIZE);

        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Customer = $this->customerRepository
                ->getRegularCustomerByEmail($form->get('login_email')->getData());

            if (!is_null($Customer)) {
                // リセットキーの発行・有効期限の設定
                $Customer
                    ->setResetKey($this->customerRepository->getUniqueResetKey())
                    ->setResetExpire(new \DateTime('+'.$this->eccubeConfig['eccube_customer_reset_expire'].' min'));

                // リセットキーを更新
                $this->entityManager->persist($Customer);
                $this->entityManager->flush();

                $event = new EventArgs(
                    [
                        'form' => $form,
                        'Customer' => $Customer,
                    ],
                    $request
                );
                $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_FORGOT_INDEX_COMPLETE);

                // 完了URLの生成
                $reset_url = $this->generateUrl('forgot_reset', ['reset_key' => $Customer->getResetKey()], UrlGeneratorInterface::ABSOLUTE_URL);

                // メール送信
                $this->mailService->sendPasswordResetNotificationMail($Customer, $reset_url);

                // ログ出力
                log_info('send reset password mail to:'."{$Customer->getId()} {$Customer->getEmail()} {$request->getClientIp()}");
            } else {
                log_warning(
                    'Un active customer try send reset password email: ',
                    ['Enter email' => $form->get('login_email')->getData()]
                );
            }

            return $this->redirectToRoute('forgot_complete');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * 再設定URL送信完了画面.
     *
     * @Route("/forgot/complete", name="forgot_complete", methods={"GET"})
     * @Template("Forgot/complete.twig")
     */
    public function complete(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new HttpException\NotFoundHttpException();
        }

        return [];
    }

    /**
     * パスワード再発行実行画面.
     *
     * @Route("/forgot/reset/{reset_key}", name="forgot_reset", methods={"GET", "POST"})
     * @Template("Forgot/reset.twig")
     */
    public function reset(Request $request, $reset_key, UserPasswordHasher $hasher)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new HttpException\NotFoundHttpException();
        }

        $errors = $this->validator->validate(
            $reset_key,
            [
                new Assert\NotBlank(),
                new Assert\Regex(
                    [
                        'pattern' => '/^[a-zA-Z0-9]+$/',
                    ]
                ),
            ]
        );

        if (count($errors) > 0) {
            // リセットキーに異常がある場合
            throw new HttpException\NotFoundHttpException();
        }

        $Customer = $this->customerRepository
            ->getRegularCustomerByResetKey($reset_key);

        if (null === $Customer) {
            // リセットキーから会員データが取得できない場合
            throw new HttpException\NotFoundHttpException();
        }

        $builder = $this->formFactory
            ->createNamedBuilder('', PasswordResetType::class);

        $form = $builder->getForm();
        $form->handleRequest($request);
        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            // リセットキー・入力メールアドレスで会員情報検索
            $Customer = $this->customerRepository
                ->getRegularCustomerByResetKey($reset_key, $form->get('login_email')->getData());
            if ($Customer) {
                // パスワードの発行・更新
                $password = $form->get('password')->getData();
                $password = $hasher->hashPassword($Customer, $password);

                // パスワードを更新
                $Customer->setPassword($password);
                // リセットキーをクリア
                $Customer->setResetKey(null);

                // パスワードを更新
                $this->entityManager->persist($Customer);
                $this->entityManager->flush();

                $event = new EventArgs(
                    [
                        'Customer' => $Customer,
                    ],
                    $request
                );
                $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_FORGOT_RESET_COMPLETE);

                // 完了メッセージを設定
                $this->addFlash('password_reset_complete', trans('front.forgot.reset_complete'));

                // ログインページへリダイレクト
                return $this->redirectToRoute('mypage_login');
            } else {
                // リセットキー・メールアドレスから会員データが取得できない場合
                $error = trans('front.forgot.reset_not_found');
            }
        }

        return [
            'error' => $error,
            'form' => $form->createView(),
        ];
    }
}
