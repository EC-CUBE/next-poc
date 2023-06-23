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

use Symfony\Component\HttpFoundation\RequestStack as Adaptee;

class RequestStack
{
    private Adaptee $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function getMainRequest(): ?Request
    {
        $request = $this->adaptee->getMainRequest();
        return is_null($request) ? null : new Request($this->adaptee, $request);
    }

    public function getCurrentRequest(): ?Request
    {
        $request = $this->adaptee->getCurrentRequest();
        return is_null($request) ? null : new Request($this->adaptee, $request);
    }

    public function push(Request $request): void
    {
        $this->adaptee->push($request->getAdaptee());
    }

    public function getSession(): Session
    {
        return new Session($this->adaptee->getSession());
    }
}
