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

namespace Eccube\Http;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class FlashBag
{
    private FlashBagInterface $adaptee;

    public function __construct(FlashBagInterface $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function get(string $type, mixed $default = null): mixed
    {
        return $this->adaptee->get($type, $default);
    }

    public function set(string $type, array|string $messages): void
    {
        $this->adaptee->set($type, $messages);
    }

    public function has(string $type): bool
    {
        return $this->adaptee->has($type);
    }

    public function add(string $type, mixed $message): void
    {
        $this->adaptee->add($type, $message);
    }

    public function clear(): mixed
    {
        return $this->adaptee->clear();
    }
}
