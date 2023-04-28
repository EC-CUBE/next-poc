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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Eccube\Form\FormBuilder;
use Eccube\OptionsResolver\OptionsResolver;

class PluginManagementType extends AbstractType
{
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $plugin_id = $options['plugin_id'];

        $builder
            ->add('plugin_id', HiddenType::class, [
                'data' => $plugin_id,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('plugin_archive', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'ファイルを選択してください。']),
                    new Assert\File([
                        'mimeTypes' => ['application/zip', 'application/x-tar', 'application/x-gzip', 'application/gzip'],
                        'mimeTypesMessage' => 'zipファイル、tarファイル、tar.gzファイルのいずれかをアップロードしてください。',
                    ]),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'plugin_management';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['plugin_id']);
    }
}
