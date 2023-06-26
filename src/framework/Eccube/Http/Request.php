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

class Request
{
    private Adaptee $adaptee;

    public InputBag $query;

    public InputBag $request;

    public FileBag $files;

    public ServerBag $server;

    public HeaderBag $headers;

    public ParameterBag $attributes;

    public static function createFromGlobals(): self
    {
        return new self();
    }

    public function __construct(Adaptee $adaptee = null, \Symfony\Component\HttpFoundation\RequestStack $requestStack = null)
    {
        if ($requestStack) {
            $this->adaptee = $requestStack->getMainRequest();
        } else {
            $this->adaptee = $adaptee ?: Adaptee::createFromGlobals();
        }
        $this->query = new InputBag($this->adaptee->query);
        $this->request = new InputBag($this->adaptee->request);
        $this->files = new FileBag($this->adaptee->files);
        $this->server = new ServerBag($this->adaptee->server);
        $this->headers = new HeaderBag($this->adaptee->headers);
        $this->attributes = new ParameterBag($this->adaptee->attributes);
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

    public function setMethod(string $method): void
    {
        $this->adaptee->setMethod($method);
    }

    public function duplicate(array $query = null, array $request = null, array $attributes = null, array $cookies = null, array $files = null, array $server = null): self
    {
        return new Request($this->adaptee->duplicate($query, $request, $attributes, $cookies, $files, $server));
    }

    /**
     * @return Adaptee
     */
    public function getAdaptee(): Adaptee
    {
        return $this->adaptee;
    }
}
