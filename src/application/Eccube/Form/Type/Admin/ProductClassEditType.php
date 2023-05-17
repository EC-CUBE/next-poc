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

namespace Eccube\Form\Type\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\ClassCategory;
use Eccube\Entity\ProductClass;
use Eccube\Form\DataTransformer;
use Eccube\Form\Form;
use Eccube\Form\FormBuilder;
use Eccube\Form\FormError;
use Eccube\Form\FormEvent;
use Eccube\Form\Type\AbstractType;
use Eccube\Form\Type\Master\DeliveryDurationType;
use Eccube\Form\Type\Master\SaleTypeType;
use Eccube\Form\Type\PriceType;
use Eccube\OptionsResolver\OptionsResolver;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Validator\Constraints as Assert;
use Eccube\Validator\ConstraintViolationList;
use Eccube\Validator\Validator;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductClassEditType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var BaseInfoRepository
     */
    protected $baseInfoRepository;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * ProductClassEditType constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param Validator $validator
     * @param BaseInfoRepository $baseInfoRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Validator $validator,
        BaseInfoRepository $baseInfoRepository,
        EccubeConfig $eccubeConfig
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->baseInfoRepository = $baseInfoRepository;
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('checked', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false,
            ])
            ->add('code', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('stock', IntegerType::class, [
                'required' => false,
            ])
            ->add('stock_unlimited', CheckboxType::class, [
                'label' => 'admin.product.stock_unlimited__short',
                'required' => false,
            ])
            ->add('sale_limit', NumberType::class, [
                'required' => false,
            ])
            ->add('price01', PriceType::class, [
                'required' => false,
            ])
            ->add('price02', PriceType::class, [
                'required' => false,
            ])
            ->add('tax_rate', TextType::class, [
                'required' => false,
            ])
            ->add('delivery_fee', PriceType::class, [
                'required' => false,
            ])
            ->add('sale_type', SaleTypeType::class, [
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('delivery_duration', DeliveryDurationType::class, [
                'required' => false,
                'placeholder' => 'common.select__unspecified',
            ]);

        $transformer = new DataTransformer\EntityToIdTransformer($this->entityManager, ClassCategory::class);
        $builder
            ->add($builder->create('ClassCategory1', HiddenType::class)
                ->addModelTransformer($transformer)
            )
            ->add($builder->create('ClassCategory2', HiddenType::class)
                ->addModelTransformer($transformer)
            );

        // 各行の個別税率設定.
        $this->setTaxRate($builder);

        // 各行の登録チェックボックス.
        $this->setCheckbox($builder);

        // バリデーションの設定. 各行にチェックが付いているときだけ検証する.
        $this->addValidations($builder);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductClass::class,
        ]);
    }

    /**
     * 各行の個別税率設定の制御.
     *
     * @param FormBuilder $builder
     */
    protected function setTaxRate(FormBuilder $builder)
    {
        if (!$this->baseInfoRepository->get()->isOptionProductTaxRule()) {
            return;
        }
        $builder->onPostSetData(function (FormEvent $event) {
            $data = $event->getData();
            if (!$data instanceof ProductClass) {
                return;
            }
            if ($data->getId() && $data->getTaxRule()) {
                $form = $event->getForm();
                $form['tax_rate']->setData($data->getTaxRule()->getTaxRate());
            }
        });
    }

    /**
     * 各行の登録チェックボックスの制御.
     *
     * @param FormBuilder $builder
     */
    protected function setCheckbox(FormBuilder $builder)
    {
        $builder->onPostSetData(function (FormEvent $event) {
            $data = $event->getData();
            if (!$data instanceof ProductClass) {
                return;
            }
            if ($data->getId() && $data->isVisible()) {
                $form = $event->getForm();
                $form['checked']->setData(true);
            }
        });

        $builder->onPostSubmit(function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $data->setVisible($form['checked']->getData() ? true : false);
        });
    }

    protected function addValidations(FormBuilder $builder)
    {
        $builder->onPostSubmit(function (FormEvent $event) {
            $form = $event->getForm();
            $data = $form->getData();

            if (!$form['checked']->getData()) {
                // チェックがついていない場合はバリデーションしない.
                return;
            }

            // 在庫数
            $errors = $this->validator->validate($data['stock'], [
                new Assert\Regex([
                    'pattern' => "/^\d+$/u",
                    'message' => 'form_error.numeric_only',
                ]),
            ]);
            $this->addErrors('stock', $form, $errors);

            // 在庫数無制限
            if (empty($data['stock_unlimited']) && null === $data['stock']) {
                $form['stock_unlimited']->addError(new FormError(trans('admin.product.product_class_set_stock_quantity')));
            }

            // 販売制限数
            $errors = $this->validator->validate($data['sale_limit'], [
                new Assert\Length([
                    'max' => 10,
                ]),
                new Assert\GreaterThanOrEqual([
                    'value' => 1,
                ]),
                new Assert\Regex([
                    'pattern' => "/^\d+$/u",
                    'message' => 'form_error.numeric_only',
                ]),
            ]);
            $this->addErrors('sale_limit', $form, $errors);

            // 販売価格
            $errors = $this->validator->validate($data['price02'], [
                new Assert\NotBlank(),
            ]);

            $this->addErrors('price02', $form, $errors);

            // 税率
            $errors = $this->validator->validate($data['tax_rate'], [
                new Assert\Range(['min' => 0, 'max' => 100]),
                new Assert\Regex([
                    'pattern' => "/^\d+(\.\d+)?$/",
                    'message' => 'form_error.float_only',
                ]),
            ]);
            $this->addErrors('tax_rate', $form, $errors);

            // 販売種別
            $errors = $this->validator->validate($data['sale_type'], [
                new Assert\NotBlank(),
            ]);
            $this->addErrors('sale_type', $form, $errors);
        });
    }

    protected function addErrors($key, Form $form, ConstraintViolationList $errors)
    {
        foreach ($errors as $error) {
            $form[$key]->addError(new FormError($error->getMessage()));
        }
    }
}
