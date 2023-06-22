<?php

declare(strict_types=1);

namespace Eccube\ORM;

use Doctrine\ORM\Query as DoctrineQuery;
use Eccube\ORM\Exception\ORMException;

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

    /**
     * @throws ORMException
     */
    public function getResult($hydrationMode = self::HYDRATE_OBJECT)
    {
        try {
            return $this->query->getResult($hydrationMode);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    public function useResultCache($useCache, $lifetime = null, $resultCacheId = null): Query
    {
        $this->query->useResultCache($useCache, $lifetime, $resultCacheId);

        return $this;
    }

    /**
     * @throws ORMException
     */
    public function getSingleResult($hydrationMode = null)
    {
        try {
            return $this->query->getSingleResult($hydrationMode);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    /**
     * @throws ORMException
     */
    public function getSingleScalarResult()
    {
        try {
            return $this->getSingleResult(self::HYDRATE_SINGLE_SCALAR);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    /**
     * @throws ORMException
     */
    public function execute($parameters = null, $hydrationMode = null)
    {
        try {
            return $this->query->execute($parameters, $hydrationMode);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }

    /**
     * @throws ORMException
     */
    public function getOneOrNullResult($hydrationMode = null)
    {
        try {
            return $this->query->getOneOrNullResult($hydrationMode);
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
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

    /**
     * @throws ORMException
     */
    public function getArrayResult()
    {
        try {
            return $this->query->getArrayResult();
        } catch (\Exception $e) {
            throw new ORMException($e);
        }
    }
}
