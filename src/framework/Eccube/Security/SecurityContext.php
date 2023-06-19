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

namespace Eccube\Security;

use Eccube\Entity\Customer;
use Eccube\Entity\Member;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityContext
{
    private TokenStorageInterface $tokenStorage;
    private AuthorizationCheckerInterface $authorizationChecker;
    private CsrfTokenManagerInterface $csrfTokenManager;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->csrfTokenManager = $csrfTokenManager;
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
     *
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

    public function getCsrfToken($tokenID): ?string
    {
        $token = $this->csrfTokenManager->getToken($tokenID);
        if ($token) {
            return $token->getValue();
        }

        return null;
    }
}
