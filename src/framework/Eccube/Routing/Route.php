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

use Symfony\Component\Routing\Route as BaseRoute;

class Route
{
    private BaseRoute $route;

    public function __construct(BaseRoute $route)
    {
        $this->route = $route;
    }

    public function getPathVariables(): array
    {
        return $this->route->compile()->getPathVariables();
    }

    public function hasPathVariables(): bool
    {
        return count($this->getPathVariables()) > 0;
    }

    public function getPath(): string
    {
        return $this->route->getPath();
    }
}
