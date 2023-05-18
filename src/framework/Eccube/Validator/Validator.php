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

namespace Eccube\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $value
     * @param Constraint|Constraint[] $constants
     * @return ConstraintViolationList
     */
    public function validate($value, $constants): ConstraintViolationList
    {
        $array = ['constraints' => $constants];
        Constraint::convertConstraints($array);
        return new ConstraintViolationList($this->validator->validate($value, $array['constraints']));
    }
}
