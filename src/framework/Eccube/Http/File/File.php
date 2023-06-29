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

use Symfony\Component\HttpFoundation\File\File as Adaptee;

class File implements FileInterface
{
    use FileTrait;

    public static function create(string $path, bool $checkPath = true): self
    {
        return new self(new Adaptee($path, $checkPath));
    }

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }
}
