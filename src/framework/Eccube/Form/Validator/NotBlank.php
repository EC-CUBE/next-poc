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

namespace Eccube\Form\Validator;

use Symfony\Component\Validator\Constraints\NotBlank as NotBlankAlias;

class NotBlank extends Constraint
{
    public function __construct(array $options = null, string $message = null, bool $allowNull = null, callable $normalizer = null, array $groups = null, $payload = null)
    {
        parent::__construct(new NotBlankAlias($options, $message, $allowNull, $normalizer, $groups, $payload));
    }
}
