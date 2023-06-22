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

use Symfony\Component\HttpFoundation\StreamedResponse as Adaptee;

class StreamedResponse extends Response
{
    private Adaptee $adaptee;

    public function __construct(callable $callback = null, int $status = 200, array $headers = [])
    {
        parent::__construct();
        $this->adaptee = new Adaptee($callback, $status, $headers);
    }

    public function setCallback(callable $callback): self
    {
        $this->adaptee->setCallback($callback);
        return $this;
    }

    /**
     * @return Adaptee
     */
    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }
}
