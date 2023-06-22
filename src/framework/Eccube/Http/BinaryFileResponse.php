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

use Symfony\Component\HttpFoundation\BinaryFileResponse as Adaptee;
use Symfony\Component\HttpFoundation\File\File;

class BinaryFileResponse extends Response
{
    private Adaptee $adaptee;

    public function __construct($file, int $status = 200, array $headers = [], bool $public = true, string $contentDisposition = null, bool $autoEtag = false, bool $autoLastModified = true)
    {
        parent::__construct();
        $this->adaptee = new Adaptee($file, $status, $headers, $public, $contentDisposition, $autoEtag, $autoLastModified);
    }

    public function setContentDisposition(string $disposition, string $filename = '', string $filenameFallback = ''): self
    {
        $this->adaptee->setContentDisposition($disposition, $filename, $filenameFallback);
        return $this;
    }

    public function getFile(): File
    {
        return $this->adaptee->getFile();
    }

    /**
     * @return Adaptee
     */
    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }
}
