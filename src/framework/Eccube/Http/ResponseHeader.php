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

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ResponseHeader
{
    private ResponseHeaderBag $adaptee;

    /**
     * @param ResponseHeaderBag $adaptee
     */
    public function __construct(ResponseHeaderBag $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function set(string $key, $values, bool $replace = true)
    {
        $this->adaptee->set($key, $values, $replace);
    }

    public function setCookie(Cookie $cookie)
    {
        $this->adaptee->setCookie($cookie);
    }
}
