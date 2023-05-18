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
use Eccube\Form\Type\AbstractType;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CsvImportType extends AbstractType
{
    /**
     * @var int CSVの最大アップロードサイズ
     */
    private $csvMaxSize;

    /**
     * CsvImportType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->csvMaxSize = $eccubeConfig['eccube_csv_size'];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('import_file', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\File([
                        'maxSize' => $this->csvMaxSize.'M',
                    ]),
                ],
            ])
            ->add('is_split_csv', CheckboxType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('csv_file_no', IntegerType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_csv_import';
    }
}
