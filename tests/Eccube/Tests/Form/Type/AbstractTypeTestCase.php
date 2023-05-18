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

namespace Eccube\Tests\Form\Type;

use Eccube\Form\FormFactory;
use Eccube\Tests\EccubeTestCase;

abstract class AbstractTypeTestCase extends EccubeTestCase
{
    /**
     * @var FormFactory
     */
    protected $formFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formFactory = static::getContainer()->get(FormFactory::class);
    }
}
