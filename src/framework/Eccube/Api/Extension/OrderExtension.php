<?php

namespace Eccube\Api\Extension;

class OrderExtension extends AbstractExtension
{
    public function __construct(\ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\OrderExtension $adaptee)
    {
        $this->adaptee = $adaptee;
    }
}
