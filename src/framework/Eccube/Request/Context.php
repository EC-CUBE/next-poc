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

namespace Eccube\Request;

use Eccube\Common\EccubeConfig;
use Eccube\Entity\Customer;
use Eccube\Entity\Member;
use Eccube\Security\SecurityContext;
use Symfony\Component\HttpFoundation\RequestStack;

class Context
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    protected SecurityContext $securityContext;

    public function __construct(RequestStack $requestStack, EccubeConfig $eccubeConfig, SecurityContext $securityContext)
    {
        $this->requestStack = $requestStack;
        $this->eccubeConfig = $eccubeConfig;
        $this->securityContext = $securityContext;
    }

    /**
     * 管理画面へのアクセスかどうか.
     *
     * @return bool
     */
    public function isAdmin()
    {
        $request = $this->requestStack->getMainRequest();

        if (null === $request) {
            return false;
        }

        $pathInfo = \rawurldecode($request->getPathInfo());
        $adminPath = $this->eccubeConfig->get('eccube_admin_route');
        $adminPath = '/'.\trim($adminPath, '/').'/';

        return \strpos($pathInfo, $adminPath) === 0;
    }

    /**
     * フロント画面へのアクセスかどうか.
     *
     * @return bool
     */
    public function isFront()
    {
        $request = $this->requestStack->getMainRequest();

        if (null === $request) {
            return false;
        }

        return false === $this->isAdmin();
    }

    /**
     * @return Member|Customer|null
     */
    public function getCurrentUser()
    {
        $request = $this->requestStack->getMainRequest();

        if (null === $request) {
            return null;
        }

        if (!$this->securityContext->hasToken()) {
            return null;
        }

        if (!is_object($user = $this->securityContext->getLoginUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}
