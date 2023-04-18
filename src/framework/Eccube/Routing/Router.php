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

use Eccube\Routing\Exception\RoutingException;
use Eccube\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Router
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function generate(string $name, array $parameters = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        try {
            return $this->router->generate($name, $parameters, $referenceType);
        } catch (\Exception $e) {
            throw new RoutingException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function match(string $path): array
    {
        try {
            return $this->router->match($path);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function matchRoute(string $path): ?string
    {
        $result = $this->match($path);

        return $result['_route'] ?? null;
    }

    public function matchParams(string $path): array
    {
        $result = $this->match($path);

        return \array_filter($result, function ($key) {
            return !\str_starts_with($key, '_');
        }, \ARRAY_FILTER_USE_KEY);
    }

    public function getRouteCollection(): RouteCollection
    {
        return new RouteCollection($this->router->getRouteCollection());
    }

    public function get(string $routeName): ?Route
    {
        return $this->getRouteCollection()->get($routeName);
    }
}
