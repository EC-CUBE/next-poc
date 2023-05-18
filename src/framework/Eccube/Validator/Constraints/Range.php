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
use Symfony\Component\Validator\Constraints\Range as Adaptee;

class Range extends Constraint
{
    public function __construct(
        array $options = null,
        string $notInRangeMessage = null,
        string $minMessage = null,
        string $maxMessage = null,
        string $invalidMessage = null,
        string $invalidDateTimeMessage = null,
        $min = null,
        $minPropertyPath = null,
        $max = null,
        $maxPropertyPath = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct(new Adaptee($options, $notInRangeMessage, $minMessage, $maxMessage, $invalidMessage, $invalidDateTimeMessage, $min, $minPropertyPath, $max, $maxPropertyPath, $groups, $payload));
    }
}
