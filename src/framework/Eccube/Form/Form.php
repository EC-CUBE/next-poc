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

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;

class Form implements \ArrayAccess, \IteratorAggregate, \Countable
{
    private FormInterface $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function isSubmitted(): bool
    {
        return $this->form->isSubmitted();
    }

    public function isValid(): bool
    {
        return $this->form->isValid();
    }

    public function handleRequest($request): Form
    {
        $this->form->handleRequest($request);
        return $this;
    }

    public function createView(): FormView
    {
        return new FormView($this->form->createView());
    }

    public function offsetExists($offset)
    {
        return $this->form->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return new Form($this->form->offsetGet($offset));
    }

    public function offsetSet($offset, $value)
    {
        /** @var Form $value */
        $this->form->offsetSet($offset, $value->form);
    }

    public function offsetUnset($offset)
    {
        $this->form->offsetUnset($offset);
    }

    public function addError(FormError $error)
    {
        $this->form->addError($error->getFormError());
    }

    public function get(string $name)
    {
        return new Form($this->form->get($name));
    }

    public function add($child, string $type = null, array $options = [])
    {
        $this->form->add($child, $type, $options);
        return $this;
    }

    public function setData($modelData)
    {
        $this->form->setData($modelData);
    }

    public function getData()
    {
        return $this->form->getData();
    }

    public function submit($submittedData, bool $clearMissing = true): Form
    {
        $this->form->submit($submittedData, $clearMissing);
        return $this;
    }

    public function getViewData()
    {
        return $this->form->getViewData();
    }

    public function all()
    {
        return array_map(function($f) { return new Form($f); }, $this->form->all());
    }

    public function getConfig()
    {
        return new FormConfig($this->form->getConfig());
    }

    public function getErrors(bool $deep = false, bool $flatten = true)
    {
        return new FormErrorIterator($this->form->getErrors($deep, $flatten));
    }

    public function isClicked()
    {
        if ($this->form instanceof SubmitButton) {
            return $this->form->isClicked();
        }
        return false;
    }

    public function getClickedButton()
    {
        if ($this->form instanceof \Symfony\Component\Form\Form && $button = $this->form->getClickedButton()) {
            return new Form($button);
        }
        return null;
    }

    public function count()
    {
        return $this->form->count();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->all());
    }
}
