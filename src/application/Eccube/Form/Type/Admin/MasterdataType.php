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

use Eccube\Entity\Master\CustomerOrderStatus;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Master\OrderStatusColor;
use Eccube\Form\FormBuilder;
use Eccube\Form\Type\AbstractType;
use Eccube\ORM\EntityManager;
use Eccube\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class MasterdataType
 */
class MasterdataType extends AbstractType
{
    protected EntityManager $entityManager;

    /**
     * MasterdataType constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $tableNames = $this->entityManager->getTableNames();

        // マスタデータのテーブル(mtb_*)のみ対象
        $tableNames = array_filter($tableNames, fn ($table) => \str_starts_with($table, 'mtb_'));

        // OrderStatus/OrderStatusColorは対象外 @see https://github.com/EC-CUBE/ec-cube/pull/4844
        $excludes = [OrderStatus::class, OrderStatusColor::class, CustomerOrderStatus::class];
        $tableNames = array_filter($tableNames, fn ($class) => !in_array($class, $excludes), \ARRAY_FILTER_USE_KEY);

        $masterdata = [];
        foreach ($tableNames as $class => $table) {
            $masterdata[str_replace('\\', '-', $class)] = $table;
        }

        $builder
            ->add('masterdata', ChoiceType::class, [
                'choices' => array_flip($masterdata),
                'expanded' => false,
                'multiple' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'admin_system_masterdata';
    }
}
