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

use Symfony\Component\Form\FormEvent as FormEventAlias;
use Symfony\Contracts\EventDispatcher\Event;

class FormEvent extends Event
{
    private FormEventAlias $formEvent;

    private Form $form;

    public function __construct(FormEventAlias $formEvent)
    {
        $this->formEvent = $formEvent;
        $this->form = new Form($formEvent->getForm());
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function getData()
    {
        return $this->formEvent->getData();
    }
}
