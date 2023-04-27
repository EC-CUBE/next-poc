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
use Symfony\Component\Validator\Constraints\Ip as Adaptee;

class Ip extends Constraint
{
    public function __construct(
        array $options = null,
        string $version = null,
        string $message = null,
        callable $normalizer = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct(new Adaptee($options, $version, $message, $normalizer, $groups, $payload));
    }
}
