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

    public function current()
    {
        return new FormError($this->adaptee->current());
    }

    public function next()
    {
        $this->adaptee->next();
    }

    public function key()
    {
        return $this->adaptee->key();
    }

    public function valid()
    {
        return $this->adaptee->valid();
    }

    public function rewind()
    {
        $this->adaptee->rewind();
    }

    public function offsetExists($offset)
    {
        return $this->adaptee->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return new FormError($this->adaptee->offsetGet($offset));
    }

    public function offsetSet($offset, $value)
    {
        /** @var FormError $value */
        $this->adaptee->offsetSet($offset, $value->getAdaptee());
    }

    public function offsetUnset($offset)
    {
        $this->adaptee->offsetUnset($offset);
    }

    public function count()
    {
        return $this->adaptee->count();
    }

    public function hasChildren()
    {
        return $this->adaptee->hasChildren();
    }

    public function getChildren()
    {
        return new FormErrorIterator($this->adaptee->getChildren());
    }

    public function seek($offset)
    {
        $this->adaptee->seek($offset);
    }
}
