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
use Symfony\Component\Validator\Constraint as ConstraintAlias;
use Symfony\Component\Validator\Constraints\Callback as Adaptee;

class Callback extends Constraint
{
    public function __construct($callback = null, array $groups = null, $payload = null, array $options = [])
    {
        parent::__construct(new Adaptee($callback, $groups, $payload, $options));
    }
}
