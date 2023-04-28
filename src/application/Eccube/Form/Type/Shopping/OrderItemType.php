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

namespace Eccube\Form\Type\Shopping;

use Eccube\Form\Type\AbstractType;
use Eccube\Form\FormBuilder;
use Eccube\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType
{
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Eccube\Entity\OrderItem',
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '_shopping_order_item';
    }
}
