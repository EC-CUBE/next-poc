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

use Doctrine\ORM\EntityRepository;
use Eccube\Entity\PageLayout;
use Eccube\Form\Type\Master\DeviceTypeType;
use Eccube\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Eccube\Form\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Eccube\Form\FormBuilder;
use Eccube\OptionsResolver\OptionsResolver;

/**
 * Class ProductType.
 */
class LayoutType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $layout_id = $options['layout_id'];

        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ]
            )->add(
                'DeviceType',
                DeviceTypeType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                    'required' => false,
                ]
            )->add('Page', EntityType::class, [
                'mapped' => false,
                'placeholder' => 'common.select',
                'required' => false,
                'choice_label' => 'Page.name',
                'choice_value' => 'page_id',
                'class' => PageLayout::class,
                'query_builder' => function (EntityRepository $er) use ($layout_id) {
                    return $er->createQueryBuilder('pl')
                        ->orderBy('pl.page_id', 'ASC')
                        ->where('pl.layout_id = :layout_id')
                        ->setParameter('layout_id', $layout_id);
                },
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Eccube\Entity\Layout',
            'layout_id' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_layout';
    }
}
