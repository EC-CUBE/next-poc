<?php

namespace Eccube\Repository;

use ApiPlatform\Core\Annotation\ApiResource;
use Eccube\Entity\Sample;
use Eccube\ORM\ManagerRegistry;

#[ApiResource]
class SampleRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sample::class);
    }
}
