<?php

namespace Eccube\Api\Extension;

class FilterEagerLoadingExtension extends AbstractExtension
{
    public function __construct(\ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\FilterEagerLoadingExtension $adaptee)
    {
        $this->adaptee = $adaptee;
    }
}
