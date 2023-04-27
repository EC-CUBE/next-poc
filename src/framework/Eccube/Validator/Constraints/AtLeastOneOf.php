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

namespace Eccube\Validator\Constraints;

use Eccube\Validator\Constraint;
use Symfony\Component\Validator\Constraints\AtLeastOneOf as Adaptee;

class AtLeastOneOf extends Constraint
{
    public function __construct($constraints = null, array $groups = null, $payload = null, string $message = null, string $messageCollection = null, bool $includeInternalMessages = null)
    {
        if (isset($constraints['constraints'])) {
            Constraint::convertConstraints($constraints);
        }
        parent::__construct(new Adaptee(array_map(function ($c) {
            return ($c instanceof Constraint) ? $c->getConstraint() : $c;
        }, $constraints), $groups, $payload, $message, $messageCollection, $includeInternalMessages));
    }
}
