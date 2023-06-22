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

namespace Eccube\Form\DataTransformer;

use Doctrine\Persistence\ObjectManager;
use Eccube\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIdTransformer implements DataTransformerInterface
{
    private ObjectManager|EntityManager $entityManager;

    private string $className;

    public function __construct(ObjectManager|EntityManager $entityManager, string $className)
    {
        $this->entityManager = $entityManager;
        $this->className = $className;
    }

    public function transform($entity)
    {
        if (null === $entity) {
            return '';
        }

        return $entity->getId();
    }

    public function reverseTransform($id)
    {
        if ('' === $id || null === $id) {
            return null;
        }

        $entity = $this->entityManager
            ->getRepository($this->className)
            ->find($id)
        ;

        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}
