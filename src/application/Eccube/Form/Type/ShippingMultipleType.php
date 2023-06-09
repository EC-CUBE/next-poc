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

namespace Eccube\Form\Type;

use Eccube\Form\FormBuilder;
use Eccube\Repository\ShippingRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ShippingMultipleType extends AbstractType
{
    /**
     * @var ShippingRepository
     */
    protected $shippingRepository;

    /**
     * ShippingMultipleType constructor.
     *
     * @param ShippingRepository $shippingRepository
     */
    public function __construct(ShippingRepository $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->onPostSetData(function ($event) {
                /** @var \Eccube\Entity\OrderItem $data */
                $data = $event->getData();
                /** @var \Symfony\Component\Form\Form $form */
                $form = $event->getForm();

                if (is_null($data)) {
                    return;
                }

                $shippings = $this->shippingRepository->findShippingsProduct($data->getOrder(), $data->getProductClass());

                // Add product class for each shipping on view
                foreach ($shippings as $key => $shipping) {
                    $shippingTmp = clone $shipping->setProductClassOfTemp($data->getProductClass());
                    $shippings[$key] = $shippingTmp;
                }
                $form
                    ->add('shipping', CollectionType::class, [
                        'entry_type' => ShippingMultipleItemType::class,
                        'data' => $shippings,
                        'allow_add' => true,
                        'allow_delete' => true,
                    ]);
            });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shipping_multiple';
    }
}
