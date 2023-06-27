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

use Eccube\Common\EccubeConfig;
use Eccube\Form\FormBuilder;
use Eccube\Form\Type\AbstractType;
use Eccube\Form\Type\FileType;
use Eccube\OptionsResolver\OptionsResolver;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TemplateType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('code', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[0-9a-zA-Z]+$/',
                    ]),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('file', FileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => trans('admin.common.select')]),
                    new Assert\File([
                        'mimeTypes' => ['application/zip', 'application/x-tar', 'application/x-gzip', 'application/gzip'],
                        'mimeTypesMessage' => trans('admin.store.template.invalid_upload_file'),
                    ]),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Eccube\Entity\Template',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_template';
    }
}
