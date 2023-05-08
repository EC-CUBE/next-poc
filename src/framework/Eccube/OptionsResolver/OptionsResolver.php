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
        Constraint::convertConstraints($defaults);
        $this->adaptee->setDefaults($defaults);
        return $this;
    }

    /**
     * TODO adapt
     */
    public function setNormalizer(string $option, \Closure $normalizer): self
    {
        if ($option === 'constraints') {
            $this->adaptee->setNormalizer($option, function (Options $options, $value) use ($normalizer) {
                $result = $normalizer($options, $value);
                $constraints = ['constraints' => $result];
                Constraint::convertConstraints($constraints);
                return $constraints['constraints'];
            });
        } else {
            $this->adaptee->setNormalizer($option, $normalizer);
        }
        return $this;
    }

    public function setRequired($optionNames): self
    {
        $this->adaptee->setRequired($optionNames);
        return $this;
    }
}
