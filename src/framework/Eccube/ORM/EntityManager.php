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

namespace Eccube\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class EntityManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRepository($entityName)
    {
        return $this->entityManager->getRepository($entityName);
    }

    public function createQueryBuilder(): QueryBuilder
    {
        // todo queryBuilderのアダプタが必要
        return $this->entityManager->createQueryBuilder();
    }

    public function createQuery(string $dql): Query
    {
        // todo queryのアダプタが必要
        return $this->entityManager->createQuery($dql);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm): NativeQuery
    {
        // todo queryのアダプタが必要
        return $this->entityManager->createNativeQuery($sql, $rsm);
    }

    public function remove($entity)
    {
        $this->entityManager->remove($entity);
    }

    public function flush($entity = null)
    {
        $this->entityManager->flush($entity);
    }

    public function persist($entity)
    {
        $this->entityManager->persist($entity);
    }

    public function detach($entity)
    {
        $this->entityManager->detach($entity);
    }

    public function clear($entityName = null)
    {
        $this->entityManager->clear($entityName);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->entityManager->lock($entity, $lockMode, $lockVersion);
    }

    public function refresh($entity, ?int $lockMode = null)
    {
        $this->entityManager->refresh($entity, $lockMode);
    }

    public function beginTransaction(): bool
    {
        return $this->entityManager->getConnection()->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->entityManager->getConnection()->commit();
    }

    public function rollBack(): bool
    {
        return $this->entityManager->getConnection()->rollBack();
    }

    public function inTransaction(): bool
    {
        return $this->entityManager->getConnection()->getNativeConnection()->inTransaction();
    }

    public function isRollbackOnly(): bool
    {
        return $this->entityManager->getConnection()->getNativeConnection()->isRollbackOnly();
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        return $this->entityManager->find($className, $id, $lockMode, $lockVersion);
    }

    public function getEntityState($entity, $assume = null)
    {
        return $this->entityManager->getUnitOfWork()->getEntityState($entity, $assume);
    }

    public function getDatabaseName(): string
    {
        return $this->entityManager->getConnection()->getDatabasePlatform()->getName();
    }

    public function getTableNames(): array
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $tableNames = [];
        foreach ($metadata as $meta) {
            $tableNames[$meta->getName()] = $meta->getTableName();
        }

        return $tableNames;
    }

    public function getDatabaseVersion(): string
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addScalarResult('v', 'v');

        $platform = $this->getDatabaseName();
        switch ($platform) {
            case 'sqlite':
                $prefix = 'SQLite version ';
                $func = 'sqlite_version()';
                break;

            case 'mysql':
                $prefix = 'MySQL ';
                $func = 'version()';
                break;

            case 'pgsql':
            default:
                $prefix = '';
                $func = 'version()';
        }

        $version = $this->entityManager
            ->createNativeQuery('select '.$func.' as v', $rsm)
            ->getSingleScalarResult();

        return $prefix.$version;
    }

    public function filterIsEnabled(string $filter): bool
    {
        return $this->entityManager->getFilters()->isEnabled($filter);
    }

    public function enableFilter(string $filter)
    {
        $this->entityManager->getFilters()->enable($filter);
    }

    public function resetSqlLogger()
    {
        $this->entityManager->getConfiguration()->setSQLLogger(null);
    }
}
