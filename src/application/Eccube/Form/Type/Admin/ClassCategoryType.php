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
use Eccube\OptionsResolver\OptionsResolver;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClassCategoryType extends AbstractType
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
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('backend_name', TextType::class, [
                'label' => 'classname.label.backend_name',
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('visible', ChoiceType::class, [
                'label' => false,
                'choices' => ['common.label.display' => true, 'common.label.hide' => false],
                'required' => true,
                'expanded' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Eccube\Entity\ClassCategory',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_class_category';
    }
}
