<?php

namespace Eccube\HttpFoundation;

use Symfony\Component\HttpFoundation\Request as BaseRequest;
use Symfony\Component\HttpFoundation\RequestStack;

class Request
{
    private BaseRequest $request;

    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request = $requestStack->getMainRequest();
    }

    public function getRequest(): BaseRequest
    {
        return $this->request;
    }

    public function setRequest(BaseRequest $request): self
    {
        $this->request = $request;

        return $this;
    }

    // todo
    public function __get(string $name)
    {
        return $this->request->$name;
    }

    // todo
    public function __call(string $name, $arguments)
    {
        return $this->request->$name(...$arguments);
    }
}

