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

namespace Eccube\OptionsResolver;

use Eccube\Validator\Constraint;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver as Adaptee;

class OptionsResolver
{
    private Adaptee $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function setDefaults(array $defaults): self
    {
        if (isset($defaults['constraints'])) {
            $c = $defaults['constraints'];
            if ($c instanceof \Closure) {
                // TODO adapt Options
                $defaults['constraints'] = function(Options $options) use ($c) {
                    $result = $c($options);
                    if (is_array($result)) {
                        $result = array_map(function($r) {
                            return ($r instanceof Constraint) ? $r->getConstraint() : $r;
                        }, $result);
                    }
                    return ($result instanceof Constraint) ? $result->getConstraint() : $result;
                };
            }
        }
        $this->adaptee->setDefaults($defaults);
        return $this;
    }
}
