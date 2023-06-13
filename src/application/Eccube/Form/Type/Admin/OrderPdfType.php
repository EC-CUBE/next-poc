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
use Eccube\Form\FormError;
use Eccube\Form\FormEvent;
use Eccube\Form\Type\AbstractType;
use Eccube\ORM\EntityManager;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class OrderPdfType.
 */
class OrderPdfType extends AbstractType
{
    /** @var EccubeConfig */
    private $eccubeConfig;

    private EntityManager $entityManager;

    /**
     * OrderPdfType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     * @param EntityManager $entityManager
     */
    public function __construct(EccubeConfig $eccubeConfig, EntityManager $entityManager)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->entityManager = $entityManager;
    }

    /**
     * Build config type form.
     *
     * @param FormBuilder $builder
     * @param array                $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $config = $this->eccubeConfig;
        $builder
            ->add('ids', TextType::class, [
                'required' => false,
                'attr' => ['readonly' => 'readonly'],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('issue_date', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
                'required' => true,
                'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--'],
                'data' => new \DateTime(),
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Range([
                        'min'=> '0003-01-01',
                        'minMessage' => 'form_error.out_of_range',
                    ]),
                ],
                'attr' => [
                    'data-target' => '#'.$this->getBlockPrefix().'_issue_date',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
            ->add('title', TextType::class, [
                'required' => true,
                'attr' => ['maxlength' => $config['eccube_stext_len']],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
            ])
            ->add('download_kind', ChoiceType::class, [
                'choices' => [
                    'admin.order.delivery_note_output_format__file' => 1,
                    'admin.order.delivery_note_output_format__browser' => 2,
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'mapped' => false,
                'placeholder' => false,
            ])
            // メッセージ
            ->add('message1', TextType::class, [
                'required' => false,
                'attr' => ['maxlength' => $config['eccube_order_pdf_message_len']],
                'constraints' => [
                    new Assert\Length(['max' => $config['eccube_order_pdf_message_len']]),
                ],
                'trim' => false,
            ])
            ->add('message2', TextType::class, [
                'required' => false,
                'attr' => ['maxlength' => $config['eccube_order_pdf_message_len']],
                'constraints' => [
                    new Assert\Length(['max' => $config['eccube_order_pdf_message_len']]),
                ],
                'trim' => false,
            ])
            ->add('message3', TextType::class, [
                'required' => false,
                'attr' => ['maxlength' => $config['eccube_order_pdf_message_len']],
                'constraints' => [
                    new Assert\Length(['max' => $config['eccube_order_pdf_message_len']]),
                ],
                'trim' => false,
            ])
            // 備考
            ->add('note1', TextType::class, [
                'required' => false,
                'attr' => ['maxlength' => $config['eccube_stext_len']],
                'constraints' => [
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
            ])
            ->add('note2', TextType::class, [
                'required' => false,
                'attr' => ['maxlength' => $config['eccube_stext_len']],
                'constraints' => [
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
            ])
            ->add('note3', TextType::class, [
                'required' => false,
                'attr' => ['maxlength' => $config['eccube_stext_len']],
                'constraints' => [
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
            ])
            ->add('default', CheckboxType::class, [
                'label' => 'admin.order.delivery_note_save_input',
                'required' => false,
            ])
            ->onPostSubmit(function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                if (!isset($data['ids']) || !is_string($data['ids'])) {
                    return;
                }
                $ids = explode(',', $data['ids']);

                $qb = $this->entityManager->createQueryBuilder();
                $qb->select('count(s.id)')
                    ->from('Eccube\\Entity\\Shipping', 's')
                    ->where($qb->expr()->in('s.id', ':ids'))
                    ->setParameter('ids', $ids);
                $actual = $qb->getQuery()->getSingleScalarResult();
                $expected = count($ids);
                if ($actual != $expected) {
                    $form['ids']->addError(
                        new FormError(trans('admin.order.delivery_note_parameter_error'))
                    );
                }
            });
    }

    /**
     * Get name method (form factory name).
     *
     * @return string
     */
    public function getName()
    {
        return 'admin_order_pdf';
    }
}
