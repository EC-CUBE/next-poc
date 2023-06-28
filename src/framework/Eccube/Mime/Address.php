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

namespace Eccube\Mime;

use Symfony\Component\Mime\Address as SymfonyAddress;

class Address
{
    private SymfonyAddress $address;

    public function __construct(string $address, string $name = '')
    {
        $this->address = new SymfonyAddress($address, $name);
    }

    public function getAddress(): string
    {
        return $this->address->getAddress();
    }

    public function getName(): string
    {
        return $this->address->getName();
    }

    public function getEncodedAddress(): string
    {
        return $this->address->getEncodedAddress();
    }

    public function toString(): string
    {
        return $this->address->toString();
    }

    public function getEncodedName(): string
    {
        return $this->address->getEncodedName();
    }
}
