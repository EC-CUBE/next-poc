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

namespace Eccube\Http;

use Eccube\Http\File\File;
use Eccube\Http\File\FileTrait;
use Eccube\Http\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag as Adaptee;

class FileBag
{
    private Adaptee $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function set(string $key, mixed $value): void
    {
        if (is_array($value)) {
            array_walk_recursive($value, function (&$item , $key) {
                $item = $this->convert($item);
            });
        } else {
            $value = $this->convert($value);
        }
        $this->adaptee->set($key, $value);
    }

    private function convert(mixed $item): mixed
    {
        if (in_array(FileTrait::class, class_uses($item))) {
            return $item->getAdaptee();
        }
        return $item;
    }
}
