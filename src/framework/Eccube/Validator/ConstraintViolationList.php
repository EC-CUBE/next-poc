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

namespace Eccube\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationList implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private ConstraintViolationListInterface $violationList;

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->violationList = $violationList;
    }

    public function count(): int
    {
        return $this->violationList->count();
    }

    public function offsetExists($offset): bool
    {
        return $this->violationList->offsetExists($offset);
    }

    public function offsetGet($offset): ConstraintViolation
    {
        return new ConstraintViolation($this->violationList->offsetGet($offset));
    }

    public function offsetSet($offset, $value): void
    {
        if (!$value instanceof ConstraintViolation) {
            throw new \InvalidArgumentException();
        }
        $this->violationList->offsetSet($offset, $value->getViolation());
    }

    public function offsetUnset($offset): void
    {
        $this->violationList->offsetUnset($offset);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator(array_map(function ($v) {
            return new ConstraintViolation($v);
        }, iterator_to_array($this->violationList)));
    }
}
