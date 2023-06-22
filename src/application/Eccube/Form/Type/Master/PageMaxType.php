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

namespace Eccube\Form\Type\Master;

use Eccube\Entity\Master\PageMax;
use Eccube\Form\FormBuilder;
use Eccube\Form\FormEvent;
use Eccube\Form\Type\AbstractType;
use Eccube\Form\Type\MasterType;
use Eccube\OptionsResolver\OptionsResolver;
use Eccube\ORM\EntityManager;

class PageMaxType extends AbstractType
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->onPreSetData(function (FormEvent $event) {
            $options = $event->getForm()->getConfig()->getOptions();
            if (!$event->getData()) {
                $data = current($options['choice_loader']->loadChoiceList()->getChoices());
                $event->setData($data);
            }
        });
        $builder->onPreSubmit(function (FormEvent $event) {
            $options = $event->getForm()->getConfig()->getOptions();
            $values = $options['choice_loader']->loadChoiceList()->getValues();
            if (!in_array($event->getData(), $values)) {
                $data = current($values);
                $event->setData($data);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => PageMax::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'page_max';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return MasterType::class;
    }
}
