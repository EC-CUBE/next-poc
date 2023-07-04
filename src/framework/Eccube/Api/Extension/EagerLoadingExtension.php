<?php

namespace Eccube\Api\Extension;

class EagerLoadingExtension extends AbstractExtension
{
    public function __construct(\ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\EagerLoadingExtension $adaptee)
    {
        $this->adaptee = $adaptee;
    }
}
