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

class FormError
{
    private \Symfony\Component\Form\FormError $formError;

    public function __construct(string $message, string $messageTemplate = null, array $messageParameters = [], int $messagePluralization = null, $cause = null)
    {
        $this->formError = new \Symfony\Component\Form\FormError($message, $messageTemplate, $messageParameters, $messagePluralization, $cause);
    }

    public function getFormError()
    {
        return $this->formError;
    }
}
