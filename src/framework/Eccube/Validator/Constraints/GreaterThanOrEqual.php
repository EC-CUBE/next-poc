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
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual as Adaptee;

class GreaterThanOrEqual extends Constraint
{
    public function __construct($value = null, $propertyPath = null, string $message = null, array $groups = null, $payload = null, array $options = [])
    {
        parent::__construct(new Adaptee($value, $propertyPath, $message, $groups, $payload, $options));
    }
}
