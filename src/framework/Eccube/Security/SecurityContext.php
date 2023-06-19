<?php

namespace Eccube\Security;

use Eccube\Entity\Customer;
use Eccube\Entity\Member;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityContext
{
    private TokenStorageInterface $tokenStorage;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
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

    /**
     * Checks if the attribute is granted against the current authentication token and optionally supplied subject.
     *
     * @param mixed $attribute A single attribute to vote on (can be of any type, string and instance of Expression are supported by the core)
     * @param mixed $subject
     *
     * @return bool
     * @see AuthorizationCheckerInterface::isGranted()
     */
    public function isGranted($attribute, $subject = null): bool
    {
        return $this->authorizationChecker->isGranted($attribute, $subject);
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
