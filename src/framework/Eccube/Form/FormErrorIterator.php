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

use Symfony\Component\Form\FormErrorIterator as Adaptee;

class FormErrorIterator implements \RecursiveIterator, \SeekableIterator, \ArrayAccess, \Countable
{

    private Adaptee $adaptee;

    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function current(): mixed
    {
        return new FormError($this->adaptee->current());
    }

    public function next(): void
    {
        $this->adaptee->next();
    }

    public function key(): int
    {
        return $this->adaptee->key();
    }

    public function valid(): bool
    {
        return $this->adaptee->valid();
    }

    public function rewind(): void
    {
        $this->adaptee->rewind();
    }

    public function offsetExists($offset): bool
    {
        return $this->adaptee->offsetExists($offset);
    }

    public function offsetGet($offset): mixed
    {
        return new FormError($this->adaptee->offsetGet($offset));
    }

    public function offsetSet($offset, $value): void
    {
        /** @var FormError $value */
        $this->adaptee->offsetSet($offset, $value->getAdaptee());
    }

    public function offsetUnset($offset): void
    {
        $this->adaptee->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->adaptee->count();
    }

    public function hasChildren(): bool
    {
        return $this->adaptee->hasChildren();
    }

    public function getChildren(): ?\RecursiveIterator
    {
        return new FormErrorIterator($this->adaptee->getChildren());
    }

    public function seek($offset): void
    {
        $this->adaptee->seek($offset);
    }

    public function __toString()
    {
        return $this->adaptee->__toString();
    }
}
