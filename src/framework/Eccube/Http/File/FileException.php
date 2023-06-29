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

namespace Eccube\Http\File;

use RuntimeException;
use Symfony\Component\HttpFoundation\File\Exception\FileException as Adaptee;

class FileException extends RuntimeException
{
    public function __construct(Adaptee $e)
    {
        parent::__construct($e->getMessage(), $e->getCode(), $e);
    }
}
