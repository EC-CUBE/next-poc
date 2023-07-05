<?php

namespace Eccube\Api\Extension;

class PaginationExtension extends AbstractExtension
{
    public function __construct(\ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension $adaptee)
    {
        $this->adaptee = $adaptee;
    }
}
