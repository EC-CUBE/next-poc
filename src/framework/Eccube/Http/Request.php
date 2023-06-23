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

    public InputBag $query;

    public InputBag $request;

    public function __construct(RequestStack $requestStack = null, Adaptee $adaptee = null)
    {
        if ($requestStack) {
            $this->requestStack = $requestStack;
            $this->adaptee = is_null($adaptee) ? $requestStack->getMainRequest() : $adaptee;
            $this->query = new InputBag($this->adaptee->query);
            $this->request = new InputBag($this->adaptee->request);
        }
    }

    public function get(string $key, $default = null): mixed
    {
        return $this->adaptee->get($key, $default);
    }

    public function getMethod(): string
    {
        return $this->adaptee->getMethod();
    }

    public function isXmlHttpRequest(): bool
    {
        return $this->adaptee->isXmlHttpRequest();
    }

    public function getSession(): Session
    {
        return new Session($this->adaptee->getSession());
    }

    public function getClientIp(): ?string
    {
        return $this->adaptee->getClientIp();
    }

    public function getClientIps(): array
    {
        return $this->adaptee->getClientIps();
    }

    public function getSchemeAndHttpHost(): string
    {
        return $this->adaptee->getSchemeAndHttpHost();
    }

    public function getBasePath(): string
    {
        return $this->adaptee->getBasePath();
    }

    /**
     * @return Adaptee
     */
    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }
}
