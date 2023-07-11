<?php

namespace Eccube\Api\Extension;

class FilterExtension extends AbstractExtension
{
    public function __construct(\ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\FilterExtension $adaptee)
    {
        $this->adaptee = $adaptee;
    }
}
