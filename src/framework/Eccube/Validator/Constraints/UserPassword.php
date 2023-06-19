<?php

namespace Eccube\Validator\Constraints;

use Eccube\Validator\Constraint;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword as Adaptee;

class UserPassword extends Constraint
{
    public function __construct(array $options = null, string $message = null, string $service = null, array $groups = null, $payload = null)
    {
        parent::__construct(new Adaptee($options, $message, $service, $groups, $payload));
    }
}
