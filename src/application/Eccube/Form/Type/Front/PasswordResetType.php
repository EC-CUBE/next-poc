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

namespace Eccube\Form\Type\Front;

use Eccube\Common\EccubeConfig;
use Eccube\Form\FormBuilder;
use Eccube\Form\FormError;
use Eccube\Form\FormEvent;
use Eccube\Form\Type\AbstractType;
use Eccube\Form\Type\RepeatedPasswordType;
use Eccube\Form\Validator\Email;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class PasswordResetType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * EntryType constructor.
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
        $builder->add('login_email', EmailType::class, [
            'attr' => [
                'maxlength' => $this->eccubeConfig['eccube_stext_len'],
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Email(null, null, $this->eccubeConfig['eccube_rfc_email_check'] ? 'strict' : null),
            ],
        ])->add('password', RepeatedPasswordType::class);

        $builder->onPostSubmit(function (FormEvent $event) {
            $form = $event->getForm();
            if ($form['password']['first']->getData() == $form['login_email']->getData()) {
                $form['password']['first']->addError(new FormError(trans('common.password_eq_email')));
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forgot_reset';
    }
}
