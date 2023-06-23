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

namespace Eccube\Form\Type;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityType extends \Symfony\Bridge\Doctrine\Form\Type\EntityType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $queryBuilderNormalizer = function (Options $options, $queryBuilder) {
            if (\is_callable($queryBuilder)) {
                $queryBuilder = $queryBuilder($options['em']->getRepository($options['class']));

                if (!$queryBuilder instanceof QueryBuilder && !$queryBuilder instanceof \Eccube\ORM\QueryBuilder) {
                    throw new UnexpectedTypeException($queryBuilder, QueryBuilder::class);
                }
            }

            return $queryBuilder;
        };

        $resolver->setNormalizer('query_builder', $queryBuilderNormalizer);
        $resolver->setAllowedTypes('query_builder', ['null', 'callable', QueryBuilder::class, \Eccube\ORM\QueryBuilder::class]);
    }

    public function getLoader(ObjectManager $manager, object $queryBuilder, string $class): ORMQueryBuilderLoader
    {
        if ($queryBuilder instanceof \Eccube\ORM\QueryBuilder) {
            $queryBuilder = $this->convertQueryBuilder($queryBuilder);
        }

        return parent::getLoader($manager, $queryBuilder, $class);
    }

    public function getQueryBuilderPartsForCachingHash(object $queryBuilder): ?array
    {
        if ($queryBuilder instanceof \Eccube\ORM\QueryBuilder) {
            $queryBuilder = $this->convertQueryBuilder($queryBuilder);
        }

        return parent::getQueryBuilderPartsForCachingHash($queryBuilder);
    }

    /**
     * @throws \ReflectionException
     */
    private function convertQueryBuilder(\Eccube\ORM\QueryBuilder $queryBuilder)
    {
        $reflectionClass = new \ReflectionClass(\Eccube\ORM\QueryBuilder::class);

        return $reflectionClass->getProperty('qb')->getValue($queryBuilder);
    }
}
