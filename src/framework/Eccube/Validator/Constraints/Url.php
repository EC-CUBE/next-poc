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
use Symfony\Component\Validator\Constraints\Url as Adaptee;

class Url extends Constraint
{
    public function __construct(
        array $options = null,
        string $message = null,
        array $protocols = null,
        bool $relativeProtocol = null,
        callable $normalizer = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct(new Adaptee($options, $message, $protocols, $relativeProtocol, $normalizer, $groups, $payload));
    }
}
