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

use Eccube\Common\EccubeConfig;
use Eccube\Form\FormBuilder;
use Eccube\OptionsResolver\OptionsResolver;
use Eccube\Validator\Constraints as Assert;

class KanaType extends AbstractType
{
    /**
     * @var \Eccube\Common\EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * KanaType constructor.
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
        // ひらがなをカタカナに変換する
        // 引数はmb_convert_kanaのもの
        $builder->addEventSubscriber(new \Eccube\Form\EventListener\ConvertKanaListener('CV'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'lastname_options' => [
                'attr' => [
                    'placeholder' => 'common.last_name_kana',
                ],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[ァ-ヶｦ-ﾟー]+$/u',
                        'message' => 'form_error.kana_only',
                    ]),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_kana_len'],
                    ]),
                ],
            ],
            'firstname_options' => [
                'attr' => [
                    'placeholder' => 'common.first_name_kana',
                ],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[ァ-ヶｦ-ﾟー]+$/u',
                        'message' => 'form_error.kana_only',
                    ]),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_kana_len'],
                    ]),
                ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return NameType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kana';
    }
}
