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

namespace Eccube\Routing;

use Symfony\Component\Routing\RouteCollection as BaseRouteCollection;

class RouteCollection
{
    private BaseRouteCollection $collection;

    public function __construct(BaseRouteCollection $collection)
    {
        $this->collection = $collection;
    }

    public function get(string $name): ?Route
    {
        $route = $this->collection->get($name);

        if (null === $route) {
            return null;
        }

        return new Route($route);
    }
}
