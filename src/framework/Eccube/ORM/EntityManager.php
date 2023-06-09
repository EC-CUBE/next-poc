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

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException as DoctrineForeignKeyConstraintViolationException;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\ORM\Exception\ForeignKeyConstraintViolationException;
use Eccube\ORM\Exception\ORMException;
use Eccube\ORM\Query;
use Eccube\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;

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
        return new QueryBuilder($this->entityManager->createQueryBuilder());
    }

    public function createQuery(string $dql): Query
    {
        return new Query($this->entityManager->createQuery($dql));
    }

    public function remove($entity)
    {
        $this->entityManager->remove($entity);
    }

    /**
     * @throws ForeignKeyConstraintViolationException
     * @throws ORMException
     */
    public function flush($entity = null)
    {
        try {
            $this->entityManager->flush($entity);
        } catch (DoctrineForeignKeyConstraintViolationException $e) {
            throw new ForeignKeyConstraintViolationException($e);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
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

    /**
     * @throws ORMException
     */
    public function pessimisticWriteLock($entity)
    {
        try {
            $this->entityManager->lock($entity, LockMode::PESSIMISTIC_WRITE);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    public function refresh($entity)
    {
        $this->entityManager->refresh($entity);
    }

    /**
     * @throws ORMException
     */
    public function beginTransaction(): bool
    {
        try {
            return $this->entityManager->getConnection()->beginTransaction();
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    public function commit(): bool
    {
        return $this->entityManager->getConnection()->commit();
    }

    /**
     * @throws ORMException
     */
    public function rollBack(): bool
    {
        try {
            return $this->entityManager->getConnection()->rollBack();
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    public function inTransaction(): bool
    {
        return $this->entityManager->getConnection()->getNativeConnection()->inTransaction();
    }

    public function isRollbackOnly(): bool
    {
        return $this->entityManager->getConnection()->getNativeConnection()->isRollbackOnly();
    }

    public function find($className, $id)
    {
        return $this->entityManager->find($className, $id);
    }

    public function isStateManaged($entity, $assume = null): bool
    {
        return UnitOfWork::STATE_MANAGED === $this->entityManager->getUnitOfWork()->getEntityState($entity, $assume);
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

    /**
     * @throws ORMException
     */
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

        try {
            $version = $this->entityManager
                ->createNativeQuery('select '.$func.' as v', $rsm)
                ->getSingleScalarResult();
        } catch (\Exception $e) {
            throw new ORMException($e);
        }

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

    public function disableSqlLogger()
    {
        $this->entityManager->getConfiguration()->setSQLLogger(null);
    }
}
