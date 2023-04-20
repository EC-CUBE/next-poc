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

use Symfony\Component\Form\FormBuilderInterface;

class FormBuilder
{

    private FormBuilderInterface $formBuilder;

    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function setMethod($method)
    {
        $this->formBuilder->setMethod($method);
        return $this;
    }

    public function getForm(): Form
    {
        return new Form($this->formBuilder->getForm());
    }

    public function add($child, string $type = null, array $options = [])
    {
        $this->formBuilder->add($child, $type, $options);
        return $this;
    }

    public function get(string $name): FormBuilder
    {
        return new FormBuilder($this->formBuilder->get($name));
    }

    public function setData($data)
    {
        $this->formBuilder->setData($data);
        return $this;
    }

    public function addEventListener(string $eventName, callable $listener, int $priority = 0)
    {
        $this->formBuilder->addEventListener($eventName, $listener, $priority);
        return $this;
    }

    public function remove(string $name)
    {
        $this->formBuilder->remove($name);
        return $this;
    }
}
