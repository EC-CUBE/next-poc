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

use Symfony\Component\HttpFoundation\Request as Adaptee;
use Symfony\Component\HttpFoundation\RequestStack;

class Request
{
    private Adaptee $adaptee;

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->adaptee = $requestStack->getMainRequest();
    }
}
