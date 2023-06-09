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
use Eccube\Entity\Calendar;
use Eccube\Form\FormBuilder;
use Eccube\Form\FormError;
use Eccube\Form\FormEvent;
use Eccube\Form\Type\AbstractType;
use Eccube\OptionsResolver\OptionsResolver;
use Eccube\Repository\CalendarRepository;
use Eccube\Validator\Constraints as Assert;
use Eccube\Validator\Validator;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class CalendarType
 */
class CalendarType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * @var CalendarRepository
     */
    protected $calendarRepository;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * CalendarType constructor.
     */
    public function __construct(EccubeConfig $eccubeConfig, Validator $validator, CalendarRepository $calendarRepository)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->calendarRepository = $calendarRepository;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('holiday', DateType::class, [
                'label' => 'admin.common.create_date__start',
                'required' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--'],
                'constraints' => [
                    new Assert\Range([
                        'min'=> '0003-01-01',
                        'minMessage' => 'form_error.out_of_range',
                    ]),
                ],
                'attr' => [
                    'class' => 'datetimepicker-input',
                    'data-target' => '#'.$this->getBlockPrefix().'_create_date_start',
                    'data-toggle' => 'datetimepicker',
                ],
            ])
        ;

        $builder->onPostSubmit(function (FormEvent $event) {
            // 日付重複チェック
            /** @var Calendar $Calendar */
            $Calendar = $event->getData();

            $errors = $this->validator->validate(
                $Calendar->getHoliday(),
                [
                    new Assert\Range([
                        'min' => '0003-01-01',
                        'minMessage' => 'form_error.out_of_range',
                    ]),
                ]
            );

            if ($errors->count()) {
                return;
            }

            $qb = $this->calendarRepository->createQueryBuilder('c');
            $qb
                ->select('count(c.id)')
                ->where('c.holiday = :holiday')
                ->setParameter('holiday', $Calendar->getHoliday());
            if ($Calendar->getId()) {
                // 更新の場合は自IDを除外してチェック
                $qb
                    ->andWhere('c.id <> :id')
                    ->setParameter('id', $Calendar->getId());
            }
            $count = $qb->getQuery()
                ->getSingleScalarResult();
            if ($count > 0) {
                $form = $event->getForm();
                $form['holiday']->addError(new FormError(trans('admin.setting.shop.calendar.holiday.available_error')));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'calendar';
    }
}
