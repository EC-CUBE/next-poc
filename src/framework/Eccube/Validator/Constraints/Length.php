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
use Symfony\Component\Validator\Constraints\Length as Adaptee;

class Length extends Constraint
{
    public function __construct(
        $exactly = null,
        int $min = null,
        int $max = null,
        string $charset = null,
        callable $normalizer = null,
        string $exactMessage = null,
        string $minMessage = null,
        string $maxMessage = null,
        string $charsetMessage = null,
        array $groups = null,
        $payload = null,
        array $options = []
    ) {
        parent::__construct(new Adaptee($exactly, $min, $max, $charset, $normalizer, $exactMessage, $minMessage, $maxMessage, $charsetMessage, $groups, $payload, $options));
    }
}
