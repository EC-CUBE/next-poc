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

use Symfony\Component\Validator\Constraint as ConstraintAlias;

class Constraint
{
    private ConstraintAlias $constraint;

    public function __construct(ConstraintAlias $constraint)
    {
        $this->constraint = $constraint;
    }

    public function getConstraint(): ConstraintAlias
    {
        return $this->constraint;
    }
}
