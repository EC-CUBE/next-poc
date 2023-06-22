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

namespace Eccube\Log\Processor;

use Eccube\Security\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TokenProcessor
{
    protected SecurityContext $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function __invoke(array $records)
    {
        $records['extra']['user_id'] = 'N/A';

        if ($this->securityContext->hasToken()) {
            $user = $this->securityContext->getLoginUser();
            $records['extra']['user_id'] = is_object($user)
                ? $user->getId()
                : $user;
        }

        return $records;
    }
}
