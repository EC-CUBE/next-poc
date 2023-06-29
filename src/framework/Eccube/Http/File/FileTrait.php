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

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File as Adaptee;

trait FileTrait
{
    private Adaptee $adaptee;

    public function getFilename(): string
    {
        return $this->adaptee->getFilename();
    }

    public function getSize(): false|int
    {
        return $this->adaptee->getSize();
    }

    public function getExtension(): string
    {
        return $this->adaptee->getExtension();
    }

    public function getMTime(): false|int
    {
        return $this->adaptee->getMTime();
    }

    public function getRealPath(): string
    {
        return $this->adaptee->getRealPath();
    }

    public function move(string $directory, string $name = null): self
    {
        try {
            $this->adaptee->move($directory, $name);
            return $this;
        } catch (FileException $e) {
            throw new \Eccube\Http\File\FileException($e);
        }
    }

    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }

    public function __toString(): string
    {
        return $this->adaptee->__toString();
    }
}
