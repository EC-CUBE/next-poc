<?php

namespace Eccube\Security\Core\User;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserPasswordHasher
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @param PasswordAuthenticatedUserInterface $user
     */
    public function hashPassword($user, string $plainPassword): string
    {
        return $this->hasher->hashPassword($user, $plainPassword);
    }

    /**
     * @param PasswordAuthenticatedUserInterface $user
     */
    public function isPasswordValid($user, string $plainPassword): bool
    {
        return $this->hasher->isPasswordValid($user, $plainPassword);
    }

    /**
     * @param PasswordAuthenticatedUserInterface $user
     */
    public function needsRehash($user): bool
    {
        return $this->hasher->needsRehash($user);
    }
}
