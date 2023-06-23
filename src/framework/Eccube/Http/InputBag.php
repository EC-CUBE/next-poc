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

use Symfony\Component\HttpFoundation\InputBag as Adaptee;

class InputBag
{
    private Adaptee $adaptee;
    public function __construct(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function get(string $key, $default = null): mixed
    {
        return $this->adaptee->get($key, $default);
    }

    public function set(string $key, mixed $value): void
    {
        $this->adaptee->set($key, $value);
    }

    public function has(string $key): bool
    {
        return $this->adaptee->has($key);
    }

    public function all(): array
    {
        return $this->adaptee->all();
    }
}
