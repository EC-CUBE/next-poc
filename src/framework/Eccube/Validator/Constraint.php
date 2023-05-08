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

use Symfony\Component\OptionsResolver\Options;
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

    public static function convertConstraints(&$options)
    {
        foreach ($options as $key => &$item) {
            if ($key === 'constraints') {
                if ($item instanceof \Closure) {
                    // TODO adapt Options
                    $item = function(Options $options) use ($item) {
                        $result = $item($options);
                        if (is_array($result)) {
                            $result = array_map(function($r) {
                                return ($r instanceof Constraint) ? $r->getConstraint() : $r;
                            }, $result);
                        }
                        return ($result instanceof Constraint) ? $result->getConstraint() : $result;
                    };
                } elseif (is_array($item)) {
                    $item = array_map(function ($c) {
                        return $c instanceof Constraint ? $c->getConstraint() : $c;
                    }, $item);
                } elseif ($item instanceof Constraint) {
                    $item = $item->getConstraint();
                }
            } elseif (is_array($item)) {
                self::convertConstraints($item);
            }
        }
    }
}
