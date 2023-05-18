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
use Eccube\Validator\Validator;
use Symfony\Component\Validator\Constraints\Cidr as Adaptee;

class Cidr extends Constraint
{
    public function __construct(
        array $options = null,
        string $version = null,
        int $netmaskMin = null,
        int $netmaskMax = null,
        string $message = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct(new Adaptee($options, $version, $netmaskMin, $netmaskMax, $message, $groups, $payload));
    }
}
