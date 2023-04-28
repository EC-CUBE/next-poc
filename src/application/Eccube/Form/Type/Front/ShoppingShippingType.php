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

namespace Eccube\Form\Type\Front;

use Eccube\Form\Type\AbstractType;
use Eccube\Form\FormBuilder;
use Eccube\OptionsResolver\OptionsResolver;

class ShoppingShippingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Eccube\Entity\CustomerAddress',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return CustomerAddressType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'shopping_shipping';
    }
}
