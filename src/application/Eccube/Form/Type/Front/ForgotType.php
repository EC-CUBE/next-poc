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
use Eccube\Form\Type\AbstractType;
use Eccube\Form\Validator\Email;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * Class ForgotType
 */
class ForgotType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * ForgotType constructor.
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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'forgot';
    }
}
