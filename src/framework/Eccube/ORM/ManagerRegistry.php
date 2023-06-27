<?php

namespace Eccube\ORM;

use Doctrine\Persistence\ManagerRegistry as DoctrineManagerRegistry;

class ManagerRegistry
{
    private DoctrineManagerRegistry $registry;

    public function __construct(DoctrineManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function getRegistry(): DoctrineManagerRegistry
    {
        return $this->registry;
    }
}
