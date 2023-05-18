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

use Symfony\Component\Form\FormError as Adaptee;

class FormError
{
    private Adaptee $adaptee;

    public function __construct()
    {
        $args = func_get_args();
        $num = func_num_args();
        if ($num == 1 && $args[0] instanceof Adaptee) {
            $this->adaptee = $args[0];
        } else {
            $this->adaptee = new Adaptee(...$args);
        }
    }

    public function getAdaptee()
    {
        return $this->adaptee;
    }

    public function getMessage(): string
    {
        return $this->adaptee->getMessage();
    }
}
