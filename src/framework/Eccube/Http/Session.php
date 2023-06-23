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

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Session
{
    private SessionInterface $adaptee;

    public function __construct(SessionInterface $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function get(string $name, $default = null): mixed
    {
        return $this->adaptee->get($name, $default);
    }

    public function set(string $name, $value): void
    {
        $this->adaptee->set($name, $value);
    }

    public function has($name): bool
    {
        return $this->adaptee->has($name);
    }

    public function remove(string $name): mixed
    {
        return $this->adaptee->remove($name);
    }

    public function clear(): void
    {
        $this->adaptee->clear();
    }
}
