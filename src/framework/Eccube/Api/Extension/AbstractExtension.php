<?php

namespace Eccube\Api\Extension;

use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Eccube\ORM\QueryBuilder;

abstract class AbstractExtension
{
    protected $adaptee;

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass = null, Operation $operation = null, array $context = []): void
    {
        $ref = new \ReflectionClass(QueryBuilder::class);
        $queryBuilder = $ref->getProperty('qb')->getValue($queryBuilder);

        $this->adaptee->applyToCollection($queryBuilder, $queryNameGenerator, $resourceClass, $operation, $context);
    }
}
