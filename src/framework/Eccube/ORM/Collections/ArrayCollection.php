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

namespace Eccube\ORM\Collections;

use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;
use Doctrine\Common\Collections\Collection;

class ArrayCollection implements Collection
{
    private Collection $collection;

    public function __construct(array $elements = [])
    {
        if (is_array($elements)) {
            $this->collection = new DoctrineArrayCollection($elements);
        } else {
            $this->collection = $elements;
        }
    }

    public function add($element)
    {
        return $this->collection->add($element);
    }

    public function clear()
    {
        $this->collection->clear();
    }

    public function remove($key)
    {
        return $this->collection->remove($key);
    }

    public function removeElement($element)
    {
        return $this->collection->removeElement($element);
    }

    public function set($key, $value)
    {
        $this->collection->set($key, $value);
    }

    public function filter(\Closure $p): ArrayCollection
    {
        $collection = $this->collection->filter($p);

        return new self($collection->toArray());
    }

    public function partition(\Closure $p)
    {
        $collections = $this->collection->partition($p);

        return [new self($collections[0]->toArray()), new self($collections[1]->toArray())];
    }

    public function getIterator(): \Traversable
    {
        return $this->collection->getIterator();
    }

    public function offsetExists($offset): bool
    {
        return $this->collection->offsetExists($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->collection->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->collection->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->collection->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function contains($element)
    {
        return $this->collection->contains($element);
    }

    public function isEmpty()
    {
        return $this->collection->isEmpty();
    }

    public function containsKey($key)
    {
        return $this->collection->containsKey($key);
    }

    public function get($key)
    {
        return $this->collection->get($key);
    }

    public function getKeys()
    {
        return $this->collection->getKeys();
    }

    public function getValues()
    {
        return $this->collection->getValues();
    }

    public function toArray()
    {
        return $this->collection->toArray();
    }

    public function first()
    {
        return $this->collection->first();
    }

    public function last()
    {
        return $this->collection->last();
    }

    public function key()
    {
        return $this->collection->key();
    }

    public function current()
    {
        return $this->collection->current();
    }

    public function next()
    {
        return $this->collection->next();
    }

    public function slice($offset, $length = null)
    {
        return $this->collection->slice($offset, $length);
    }

    public function exists(\Closure $p)
    {
        return $this->collection->exists($p);
    }

    public function map(\Closure $func)
    {
        return new self($this->collection->map($func)->toArray());
    }

    public function forAll(\Closure $p)
    {
        return $this->collection->forAll($p);
    }

    public function indexOf($element)
    {
        return $this->collection->indexOf($element);
    }
}
