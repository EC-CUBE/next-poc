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

use Symfony\Component\Form\FormConfigInterface;

class FormConfig
{
    private FormConfigInterface $config;

    public function __construct(FormConfigInterface $config)
    {
        $this->config = $config;
    }

    public function hasOption(string $name)
    {
        return $this->config->hasOption($name);
    }
}
