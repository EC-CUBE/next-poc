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

use Eccube\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormTypeWrapper implements FormTypeInterface
{
    private AbstractType $type;

    public function __construct(AbstractType $type)
    {
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->type->buildForm(new FormBuilder($builder), $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // TODO: Implement buildView() method.
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        // TODO: Implement finishView() method.
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $this->type->configureOptions(new \Eccube\OptionsResolver\OptionsResolver($resolver));
    }

    public function getBlockPrefix()
    {
        return $this->type->getBlockPrefix();
    }

    public function getParent()
    {
        return FormType::class;
    }
}
