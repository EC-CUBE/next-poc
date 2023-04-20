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

use Symfony\Component\Form\FormView as View;

class FormView
{
    private View $formView;

    public function __construct(View $formView)
    {
        $this->formView = $formView;
    }

    public function getFormView()
    {
        return $this->formView;
    }
}
