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

    public function __construct(string $message, string $messageTemplate = null, array $messageParameters = [], int $messagePluralization = null, $cause = null)
    {
        $this->adaptee = new Adaptee($message, $messageTemplate, $messageParameters, $messagePluralization, $cause);
    }

    public function getAdaptee()
    {
        return $this->adaptee;
    }
}
