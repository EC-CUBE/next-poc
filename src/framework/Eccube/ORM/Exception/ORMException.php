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

namespace Eccube\ORM\Exception;

class ORMException extends \Exception
{
    public static function wrapORMException(\Exception $e): ORMException
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }

    public static function wrapForeignKeyException(\Exception $e): ForeignKeyConstraintViolationException
    {
        return new ForeignKeyConstraintViolationException($e->getMessage(), $e->getCode(), $e);
    }
}
