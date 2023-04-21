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

namespace Eccube\Form;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\ResolvedFormTypeFactoryInterface;

class FormRegistry implements FormRegistryInterface
{
    private FormRegistryInterface $formRegistry;

    private ResolvedFormTypeFactoryInterface $resolvedFormTypeFactory;

    public function __construct(FormRegistryInterface $formRegistry)
    {
        $this->formRegistry = $formRegistry;
    }

    /**
     * @param ResolvedFormTypeFactoryInterface $resolvedFormTypeFactory
     * @required
     */
    public function setResolvedFormTypeFactory(ResolvedFormTypeFactoryInterface $resolvedFormTypeFactory): void
    {
        $this->resolvedFormTypeFactory = $resolvedFormTypeFactory;
    }

    public function getType(string $name)
    {
        if (is_subclass_of($name, FormTypeInterface::class)) {
            return $this->formRegistry->getType($name);
        }

        $type = null;
        $extensions = $this->formRegistry->getExtensions();
        foreach ($extensions as $extension) {
            if ($extension->hasType($name)) {
                $type = $extension->getType($name);
                break;
            }
        }

        $typeExtensions = [];
        try {
            foreach ($extensions as $extension) {
                $typeExtensions[] = $extension->getTypeExtensions($name);
            }

            return $this->resolvedFormTypeFactory->createResolvedType(
                new FormTypeWrapper($type),
                array_merge([], ...$typeExtensions),
                $this->getType(FormType::class)
            );
        } finally {
//            unset($this->checkedTypes[$fqcn]);
        }
    }

    public function hasType(string $name)
    {
        return $this->formRegistry->hasType($name);
    }

    public function getTypeGuesser()
    {
        return $this->formRegistry->getTypeGuesser();
    }

    public function getExtensions()
    {
        return $this->formRegistry->getExtensions();
    }
}
