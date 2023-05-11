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

namespace Eccube\Form\Type;

use Eccube\Form\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Eccube\Form\Form;
use Eccube\Form\FormView;
use Eccube\OptionsResolver\OptionsResolver;

class ToggleSwitchType extends AbstractType
{
    public function buildView(FormView $view, Form $form, array $options)
    {
        $view->vars['label_on'] = $options['label_on'];
        $view->vars['label_off'] = $options['label_off'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
            'label_on' => 'common.enabled',
            'label_off' => 'common.disabled',
        ]);
    }

    public function getParent()
    {
        return CheckboxType::class;
    }
}
