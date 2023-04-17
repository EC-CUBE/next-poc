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

namespace Eccube\DependencyInjection\Compiler;

use Eccube\Annotation\Route;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RouteAnnotationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $loader = $container->getDefinition('routing.loader.annotation');
        $loader->addMethodCall('setRouteAnnotationClass', [Route::class]);

        $loader = $container->getDefinition('sensio_framework_extra.routing.loader.annot_class');
        $loader->addMethodCall('setRouteAnnotationClass', [Route::class]);
    }
}
