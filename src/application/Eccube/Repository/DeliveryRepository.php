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

namespace Eccube\Repository;

use Eccube\ORM\ManagerRegistry;
use Eccube\Entity\Delivery;
use Eccube\Entity\Payment;

/**
 * DelivRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DeliveryRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Delivery::class);
    }

    /**
     * 複数の販売種別から配送業者を取得
     *
     * @param $saleTypes
     *
     * @return array
     */
    public function getDeliveries($saleTypes)
    {
        $deliveries = $this->createQueryBuilder('d')
            ->where('d.SaleType in (:saleTypes)')
            ->andWhere('d.visible = :visible')
            ->setParameter('saleTypes', $saleTypes)
            ->setParameter('visible', true)
            ->orderBy('d.sort_no', 'DESC')
            ->getQuery()
            ->getResult();

        return $deliveries;
    }

    /**
     * 選択可能な配送業者を取得
     *
     * @param $saleTypes
     * @param $payments
     *
     * @return array
     */
    public function findAllowedDeliveries($saleTypes, $payments)
    {
        $d = $this->getDeliveries($saleTypes);
        $arr = [];

        foreach ($d as $Delivery) {
            $paymentOptions = $Delivery->getPaymentOptions();

            foreach ($paymentOptions as $PaymentOption) {
                foreach ($payments as $Payment) {
                    if ($PaymentOption->getPayment() instanceof Payment) {
                        if ($PaymentOption->getPayment()->getId() == $Payment['id']) {
                            $arr[$Delivery->getId()] = $Delivery;
                            break;
                        }
                    }
                }
            }
        }

        return array_values($arr);
    }
}
