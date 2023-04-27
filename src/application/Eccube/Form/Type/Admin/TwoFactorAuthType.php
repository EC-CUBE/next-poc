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

use Eccube\Validator\Constraints as Assert;
use Eccube\Form\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Eccube\Form\FormBuilder;

class TwoFactorAuthType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add(
                'device_token', TextType::class, [
                    'label' => 'admin.setting.system.two_factor_auth.device_token',
                    'required' => true,
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length([
                            'max' => 6,
                            'min' => 6,
                        ]),
                    ],
                    'attr' => [
                        'maxlength' => 6,
                        'style' => 'width: 100px;',
                    ],
            ])
            ->add(
                'auth_key', HiddenType::class, [
                    'required' => true,
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_two_factor_auth';
    }
}
