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

use Symfony\Component\HttpFoundation\File\UploadedFile as Adaptee;

class UploadedFile implements FileInterface
{
    use FileTrait;

    public static function create(string $path, string $originalName, string $mimeType = null, int $error = null, bool $test = false): self
    {
        return new self(new Adaptee($path, $originalName, $mimeType, $error, $test));
    }

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function getClientOriginalName(): string
    {
        return $this->adaptee->getClientOriginalName();
    }

    public function getClientOriginalExtension(): string
    {
        return $this->adaptee->getClientOriginalExtension();
    }
}
