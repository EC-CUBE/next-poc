<?php

declare(strict_types=1);

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

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;

class QueryBuilder
{
    private DoctrineQueryBuilder $qb;

    public function __construct(DoctrineQueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    public function expr(): Expr
    {
        return $this->qb->expr();
    }

    public function setCacheable($cacheable): QueryBuilder
    {
        $this->qb->setCacheable($cacheable);

        return $this;
    }

    public function isCacheable(): bool
    {
        return $this->qb->isCacheable();
    }

    public function setCacheRegion($cacheRegion): QueryBuilder
    {
        $this->qb->setCacheRegion($cacheRegion);

        return $this;
    }

    public function getCacheRegion(): ?string
    {
        return $this->qb->getCacheRegion();
    }

    public function getLifetime(): int
    {
        return $this->qb->getLifetime();
    }

    public function setLifetime($lifetime): QueryBuilder
    {
        $this->qb->setLifetime($lifetime);

        return $this;
    }

    public function getCacheMode(): ?int
    {
        return $this->qb->getCacheMode();
    }

    public function setCacheMode($cacheMode): QueryBuilder
    {
        $this->qb->setCacheMode($cacheMode);

        return $this;
    }

    public function getType(): int
    {
        return $this->qb->getType();
    }

    public function getEntityManager(): EntityManager
    {
        return new EntityManager($this->qb->getEntityManager());
    }

    public function getState(): int
    {
        return $this->qb->getState();
    }

    public function getDQL(): ?string
    {
        return $this->qb->getDQL();
    }

    public function getQuery(): Query
    {
        return $this->qb->getQuery();
    }

    public function getRootAlias(): string
    {
        return $this->qb->getRootAlias();
    }

    public function getRootAliases(): string
    {
        return $this->qb->getRootAlias();
    }

    public function getAllAliases(): array
    {
        return $this->qb->getAllAliases();
    }

    public function getRootEntities()
    {
        return $this->qb->getRootEntities();
    }

    public function setParameter($key, $value, $type = null)
    {
        $this->qb->setParameter($key, $value, $type = null);

        return $this;
    }

    public function setParameters($parameters)
    {
        $this->qb->setParameters($parameters);

        return $this;
    }

    public function getParameters()
    {
        return $this->qb->getParameters();
    }

    public function getParameter($key): ?Parameter
    {
        return $this->qb->getParameter($key);
    }

    public function setFirstResult($firstResult): QueryBuilder
    {
        $this->qb->setFirstResult($firstResult);

        return $this;
    }

    public function getFirstResult(): ?int
    {
        return $this->qb->getFirstResult();
    }

    public function setMaxResults($maxResults): QueryBuilder
    {
        $this->qb->setMaxResults($maxResults);

        return $this;
    }

    public function getMaxResults(): ?int
    {
        return $this->qb->getMaxResults();
    }

    public function add($dqlPartName, $dqlPart, $append = false)
    {
        $this->qb->add($dqlPartName, $dqlPart, $append);

        return $this;
    }

    public function select($select = null): QueryBuilder
    {
        $this->qb->select($select);

        return $this;
    }

    public function distinct($flag = true): QueryBuilder
    {
        $this->qb->distinct($flag);

        return $this;
    }

    public function addSelect($select = null): QueryBuilder
    {
        $this->qb->addSelect($select);

        return $this;
    }

    public function delete($delete = null, $alias = null): QueryBuilder
    {
        $this->qb->delete($delete, $alias);

        return $this;
    }

    public function update($update = null, $alias = null): QueryBuilder
    {
        $this->qb->update($update, $alias);

        return $this;
    }

    public function from($from, $alias, $indexBy = null): QueryBuilder
    {
        $this->qb->from($from, $alias, $indexBy);

        return $this;
    }

    /**
     * @throws QueryException
     */
    public function indexBy($alias, $indexBy): QueryBuilder
    {
        $this->qb->indexBy($alias, $indexBy);

        return $this;
    }

    public function join($join, $alias, $conditionType = null, $condition = null, $indexBy = null): QueryBuilder
    {
        $this->qb->innerJoin($join, $alias, $conditionType, $condition, $indexBy);

        return $this;
    }

    public function innerJoin($join, $alias, $conditionType = null, $condition = null, $indexBy = null): QueryBuilder
    {
        $this->qb->innerJoin($join, $alias, $conditionType, $condition, $indexBy);

        return $this;
    }

    public function leftJoin($join, $alias, $conditionType = null, $condition = null, $indexBy = null): QueryBuilder
    {
        $this->qb->leftJoin($join, $alias, $conditionType, $condition, $indexBy);

        return $this;
    }

    public function set($key, $value): QueryBuilder
    {
        $this->qb->set($key, $value);

        return $this;
    }

    public function where($predicates): QueryBuilder
    {
        $this->qb->where($predicates);

        return $this;
    }

    public function andWhere(...$args): QueryBuilder
    {
        $this->qb->andWhere(...$args);

        return $this;
    }

    public function orWhere(...$args): QueryBuilder
    {
        $this->qb->orWhere(...$args);

        return $this;
    }

    public function groupBy($groupBy): QueryBuilder
    {
        $this->qb->groupBy($groupBy);

        return $this;
    }

    public function addGroupBy($groupBy): QueryBuilder
    {
        $this->qb->addGroupBy($groupBy);

        return $this;
    }

    public function having($having): QueryBuilder
    {
        $this->qb->having($having);

        return $this;
    }

    public function andHaving($having): QueryBuilder
    {
        $this->qb->andHaving($having);

        return $this;
    }

    public function orHaving($having): QueryBuilder
    {
        $this->qb->orHaving($having);

        return $this;
    }

    public function orderBy($sort, $order = null): QueryBuilder
    {
        $this->qb->orderBy($sort, $order);

        return $this;
    }

    public function addOrderBy($sort, $order = null): QueryBuilder
    {
        $this->qb->addOrderBy($sort, $order);

        return $this;
    }

    /**
     * @throws QueryException
     */
    public function addCriteria(Criteria $criteria): QueryBuilder
    {
        $this->qb->addCriteria($criteria);

        return $this;
    }

    public function getDQLPart($queryPartName)
    {
        return $this->qb->getDQLPart($queryPartName);
    }

    public function getDQLParts(): array
    {
        return $this->qb->getDQLParts();
    }

    public function resetDQLParts($parts = null): QueryBuilder
    {
        $this->qb->resetDQLParts($parts);

        return $this;
    }

    public function resetDQLPart($part): QueryBuilder
    {
        $this->qb->resetDQLPart($part);

        return $this;
    }

    public function __toString()
    {
        return $this->qb->getDQL();
    }

    public function __clone()
    {
        $this->qb = clone $this->qb;
    }
}
