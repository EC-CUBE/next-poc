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
use Symfony\Component\Validator\Constraints\Type as Adaptee;

class Type extends Constraint
{
    public function __construct($type, string $message = null, array $groups = null, $payload = null, array $options = [])
    {
        parent::__construct(new Adaptee($type, $message, $groups, $payload, $options));
    }
}
