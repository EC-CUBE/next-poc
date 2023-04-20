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
use Symfony\Component\Form\FormFactoryInterface;

class FormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function createBuilder(string $type = FormType::class, $data = null, array $options = [])
    {
        return new FormBuilder($this->formFactory->createBuilder($type, $data, $options));
    }

    public function createNamedBuilder(string $name, string $type = FormType::class, $data = null, array $options = [])
    {
        return new FormBuilder($this->formFactory->createNamedBuilder($name, $type, $data, $options));
    }

    public function create(string $type = FormType::class, $data = null, array $options = []): Form
    {
        return new Form($this->formFactory->create($type, $data, $options));
    }

    public function createNamed(string $name, string $type = FormType::class, $data = null, array $options = [])
    {
        return new Form($this->formFactory->createNamed($name, $type, $data, $options));
    }
}
