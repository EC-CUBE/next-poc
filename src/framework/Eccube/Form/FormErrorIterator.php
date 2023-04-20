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

use RecursiveIterator;

class FormErrorIterator implements \RecursiveIterator, \SeekableIterator, \ArrayAccess, \Countable
{

    private \Symfony\Component\Form\FormErrorIterator $iterator;

    public function __construct(\Symfony\Component\Form\FormErrorIterator $iterator)
    {
        $this->iterator = $iterator;
    }

    public function current()
    {
        return new FormError($this->iterator->current());
    }

    public function next()
    {
        $this->iterator->next();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function offsetExists($offset)
    {
        return $this->iterator->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return new FormError($this->iterator->offsetGet($offset));
    }

    public function offsetSet($offset, $value)
    {
        /** @var FormError $value */
        $this->iterator->offsetSet($offset, $value->getFormError());
    }

    public function offsetUnset($offset)
    {
        $this->iterator->offsetUnset($offset);
    }

    public function count()
    {
        return $this->iterator->count();
    }

    public function hasChildren()
    {
        return $this->iterator->hasChildren();
    }

    public function getChildren()
    {
        return new FormErrorIterator($this->iterator->getChildren());
    }

    public function seek($offset)
    {
        $this->iterator->seek($offset);
    }
}
