<?php

namespace Eccube\Security;

use Eccube\Entity\Customer;
use Eccube\Entity\Member;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class SecurityContext
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getLoginCustomer(): ?Customer
    {
        $user = $this->getLoginUser();
        if (!$user instanceof Customer) {
            return null;
        }

        return $user;
    }

    public function getLoginMember(): ?Member
    {
        $user = $this->getLoginUser();
        if (!$user instanceof Member) {
            return null;
        }

        return $user;
    }

    public function getLoginUser()
    {
        $token = $this->getToken();
        if (!$token) {
            return null;
        }

        return $token->getUser();
    }

    public function logout(): void
    {
        $this->tokenStorage->setToken(null);
    }

    public function isGranted(string $role): bool
    {
        $token = $this->getToken();
        if (!$token) {
            return false;
        }

        return $token->isGranted($role);
    }

    public function getEncoder(): ?PasswordEncoderInterface
    {
        $token = $this->getToken();
        if (!$token) {
            return null;
        }

        return $token->getEncoderFactory()->getEncoder($token->getUser());
    }

    protected function getToken(): ?TokenInterface
    {
        return $this->tokenStorage->getToken();
    }

    public function hasToken(): bool
    {
        return $this->tokenStorage->getToken() !== null;
    }
}
