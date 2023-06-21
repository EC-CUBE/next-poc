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

namespace Eccube\Controller\Mypage;

use Eccube\Controller\AbstractController;
use Eccube\Controller\Annotation\Template;
use Eccube\Entity\Customer;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Form\Type\Front\EntryType;
use Eccube\Repository\CustomerRepository;
use Eccube\Routing\Annotation\Route;
use Eccube\Security\Core\User\UserPasswordHasher;
use Symfony\Component\HttpFoundation\Request;

class ChangeController extends AbstractController
{
    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    public function __construct(
        CustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * 会員情報編集画面.
     *
     * @Route("/mypage/change", name="mypage_change", methods={"GET", "POST"})
     * @Template("Mypage/change.twig")
     */
    public function index(Request $request, UserPasswordHasher $hasher)
    {
        /** @var Customer $Customer */
        $Customer = $this->getUser();
        $Customer->setPlainPassword($this->eccubeConfig['eccube_default_password']);

        /* @var $builder \Eccube\Form\FormBuilder */
        $builder = $this->formFactory->createBuilder(EntryType::class, $Customer);

        $event = new EventArgs(
            [
                'builder' => $builder,
                'Customer' => $Customer,
            ],
            $request
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_MYPAGE_CHANGE_INDEX_INITIALIZE);

        /* @var $form \Eccube\Form\Form */
        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            log_info('会員編集開始');

            if ($Customer->getPlainPassword() !== $this->eccubeConfig['eccube_default_password']) {
                $password = $hasher->hashPassword($Customer, $Customer->getPlainPassword());
                $Customer->setPassword($password);
            }
            $this->entityManager->flush();

            log_info('会員編集完了');

            $event = new EventArgs(
                [
                    'form' => $form,
                    'Customer' => $Customer,
                ],
                $request
            );
            $this->eventDispatcher->dispatch($event, EccubeEvents::FRONT_MYPAGE_CHANGE_INDEX_COMPLETE);

            return $this->redirect($this->generateUrl('mypage_change_complete'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * 会員情報編集完了画面.
     *
     * @Route("/mypage/change_complete", name="mypage_change_complete", methods={"GET"})
     * @Template("Mypage/change_complete.twig")
     */
    public function complete(Request $request)
    {
        return [];
    }
}
