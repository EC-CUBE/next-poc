<?php

namespace Eccube\HttpFoundation\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface as BaseSessionInterface;

class Session
{
    private BaseSessionInterface $session;

    public function __construct(BaseSessionInterface $session)
    {
        $this->session = $session;
    }

    // todo
    public function __call($name, $arguments)
    {
        return $this->session->$name(...$arguments);
    }
}
