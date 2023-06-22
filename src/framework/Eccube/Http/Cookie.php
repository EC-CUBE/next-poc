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

use Symfony\Component\HttpFoundation\Cookie as Adaptee;

class Cookie
{
    public const SAMESITE_NONE = Adaptee::SAMESITE_NONE;
    public const SAMESITE_LAX = Adaptee::SAMESITE_LAX;
    public const SAMESITE_STRICT = Adaptee::SAMESITE_STRICT;

    private Adaptee $adaptee;

    public function __construct(string $name, string $value = null, $expire = 0, ?string $path = '/', string $domain = null, bool $secure = null, bool $httpOnly = true, bool $raw = false, ?string $sameSite = 'lax')
    {
        $this->adaptee = new Adaptee($name, $value, $expire, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
    }

    /**
     * @return Adaptee
     */
    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }
}
