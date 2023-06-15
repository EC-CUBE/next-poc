<?php

declare(strict_types=1);

namespace Eccube\ORM;

use Doctrine\ORM\Query as DoctrineQuery;

class Query
{
    /* Hydration mode constants */

    /**
     * Hydrates an object graph. This is the default behavior.
     */
    public const HYDRATE_OBJECT = 1;

    /**
     * Hydrates an array graph.
     */
    public const HYDRATE_ARRAY = 2;

    /**
     * Hydrates a flat, rectangular result set with scalar values.
     */
    public const HYDRATE_SCALAR = 3;

    /**
     * Hydrates a single scalar value.
     */
    public const HYDRATE_SINGLE_SCALAR = 4;

    /**
     * Very simple object hydrator (optimized for performance).
     */
    public const HYDRATE_SIMPLEOBJECT = 5;

    /**
     * Hydrates scalar column value.
     */
    public const HYDRATE_SCALAR_COLUMN = 6;

    private DoctrineQuery $query;

    public function __construct(DoctrineQuery $query)
    {
        $this->query = $query;
    }

    public function getResult($hydrationMode = self::HYDRATE_OBJECT)
    {
        return $this->query->getResult($hydrationMode);
    }

    public function useResultCache($useCache, $lifetime = null, $resultCacheId = null): Query
    {
        $this->query->useResultCache($useCache, $lifetime, $resultCacheId);

        return $this;
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getSingleResult($hydrationMode = null)
    {
        return $this->query->getSingleResult($hydrationMode);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getSingleScalarResult()
    {
        return $this->getSingleResult(self::HYDRATE_SINGLE_SCALAR);
    }

    public function execute($parameters = null, $hydrationMode = null)
    {
        return $this->query->execute($parameters, $hydrationMode);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneOrNullResult($hydrationMode = null)
    {
        return $this->query->getOneOrNullResult($hydrationMode);
    }

    public function setParameters($parameters): Query
    {
        $this->query->setParameters($parameters);

        return $this;
    }

    public function expireResultCache($expire = true): Query
    {
        $this->query->expireResultCache($expire);

        return $this;
    }

    public function getArrayResult()
    {
        return $this->query->getArrayResult();
    }
}
