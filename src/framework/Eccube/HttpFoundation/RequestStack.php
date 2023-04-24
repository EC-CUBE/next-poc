<?php

namespace Eccube\HttpFoundation;

use Symfony\Component\HttpFoundation\RequestStack as BaseRequestStack;

class RequestStack
{
    private BaseRequestStack $requestStack;

    public function __construct(BaseRequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getMainRequest(): Request
    {
        return (new Request($this->requestStack))
            ->setRequest($this->requestStack->getMainRequest());
    }

    public function getCurrentRequest(): Request
    {
        return (new Request($this->requestStack))
            ->setRequest($this->requestStack->getCurrentRequest());
    }
}
