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
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class MasterdataDataType
 */
class MasterdataDataType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * MasterdataDataType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
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
            ->add('id', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_int_len'],
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^\d+$/u',
                        'message' => 'form_error.numeric_only',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'required' => false,
            ])
        ->onPostSubmit(function (FormEvent $event) {
            $form = $event->getForm();
            $data = $form->getData();
            if (strlen($data['id']) && strlen($data['name']) == 0) {
                $form['name']->addError(new FormError(trans('This value should not be blank.', [], 'validators')));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_system_masterdata_data';
    }
}
