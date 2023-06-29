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

namespace Eccube\Http\Exception;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpException as Adaptee;

abstract class HttpException extends RuntimeException
{
    private Adaptee $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        parent::__construct($adaptee->getMessage(), $adaptee->getCode(), $adaptee->getPrevious());
        $this->adaptee = $adaptee;
    }

    /**
     * @return Adaptee
     */
    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }
}
