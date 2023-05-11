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

namespace Eccube\Form;

use Symfony\Component\Form\FormView as Adaptee;

class FormView
{
    private Adaptee $adaptee;

    public array $vars;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
        $this->vars = $adaptee->vars;
    }

    public function getAdaptee()
    {
        return $this->adaptee;
    }

    public function __get(string $name)
    {
        throw new \InvalidArgumentException($name);
    }
}
