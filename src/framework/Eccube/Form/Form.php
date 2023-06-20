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

use Eccube\Validator\Constraint;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\SubmitButton;

class Form implements \ArrayAccess, \IteratorAggregate, \Countable
{
    public const CheckBox = CheckboxType::class;
    public const Text = TextType::class;
    public const Birthday = BirthdayType::class;

    private FormInterface $adaptee;

    public function __construct(FormInterface $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function isSubmitted(): bool
    {
        return $this->adaptee->isSubmitted();
    }

    public function isValid(): bool
    {
        return $this->adaptee->isValid();
    }

    public function handleRequest($request): Form
    {
        $this->adaptee->handleRequest($request);
        return $this;
    }

    public function createView(): FormView
    {
        return new FormView($this->adaptee->createView());
    }

    public function offsetExists($offset): bool
    {
        return $this->adaptee->offsetExists($offset);
    }

    public function offsetGet($offset): mixed
    {
        return new Form($this->adaptee->offsetGet($offset));
    }

    public function offsetSet($offset, $value): void
    {
        /** @var Form $value */
        $this->adaptee->offsetSet($offset, $value->adaptee);
    }

    public function offsetUnset($offset): void
    {
        $this->adaptee->offsetUnset($offset);
    }

    public function addError(FormError $error)
    {
        $this->adaptee->addError($error->getAdaptee());
    }

    public function get(string $name)
    {
        return new Form($this->adaptee->get($name));
    }

    public function add($child, string $type = null, array $options = [])
    {
        Constraint::convertConstraints($options);
        $this->adaptee->add($child, $type, $options);
        return $this;
    }

    public function setData($modelData)
    {
        $this->adaptee->setData($modelData);
    }

    public function getData()
    {
        return $this->adaptee->getData();
    }

    public function submit($submittedData, bool $clearMissing = true): Form
    {
        $this->adaptee->submit($submittedData, $clearMissing);
        return $this;
    }

    public function getViewData()
    {
        return $this->adaptee->getViewData();
    }

    public function all()
    {
        return array_map(function($f) { return new Form($f); }, $this->adaptee->all());
    }

    public function getConfig()
    {
        return new FormConfig($this->adaptee->getConfig());
    }

    public function getErrors(bool $deep = false, bool $flatten = true)
    {
        return new FormErrorIterator($this->adaptee->getErrors($deep, $flatten));
    }

    public function isClicked()
    {
        if ($this->adaptee instanceof SubmitButton) {
            return $this->adaptee->isClicked();
        }
        return false;
    }

    public function getClickedButton()
    {
        if ($this->adaptee instanceof \Symfony\Component\Form\Form && $button = $this->adaptee->getClickedButton()) {
            return new Form($button);
        }
        return null;
    }

    public function count(): int
    {
        return $this->adaptee->count();
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->all());
    }

    public function getName(): string
    {
        return $this->adaptee->getName();
    }

    public function remove(string $name): self
    {
        $this->adaptee->remove($name);
        return $this;
    }

    public function getParent(): ?self
    {
        $parent = $this->adaptee->getParent();
        if ($parent) {
            return new Form($parent);
        }
        return null;
    }

    public function getRoot(): ?self
    {
        return new Form($this->adaptee->getRoot());
    }
}
