<?php

namespace Eccube\Security\Http\Authentication;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils as SymfonyAuthenticationUtils;

class AuthenticationUtils
{
    private SymfonyAuthenticationUtils $utils;

    public function __construct(SymfonyAuthenticationUtils $utils)
    {
        $this->utils = $utils;
    }

    public function getLastAuthenticationError(bool $clearSession = true): ?AuthenticationException
    {
        return $this->utils->getLastAuthenticationError($clearSession);
    }

    public function getLastUsername(): string
    {
        return $this->utils->getLastUsername();
    }
}
