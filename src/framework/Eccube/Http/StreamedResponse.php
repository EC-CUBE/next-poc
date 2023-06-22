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
    public function __construct(callable $callback = null, int $status = 200, array $headers = [])
    {
        parent::__construct();
        $this->setAdaptee(new Adaptee($callback, $status, $headers));
    }

    public function setCallback(callable $callback): self
    {
        $this->getAdaptee()->setCallback($callback);
        return $this;
    }
}
