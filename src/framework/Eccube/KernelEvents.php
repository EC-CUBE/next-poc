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

namespace Eccube;

use Symfony\Component\HttpKernel\KernelEvents as SymfonyKernelEvents;

class KernelEvents
{
    public const REQUEST = SymfonyKernelEvents::REQUEST;
    public const EXCEPTION = SymfonyKernelEvents::EXCEPTION;
    public const CONTROLLER = SymfonyKernelEvents::CONTROLLER;
    public const CONTROLLER_ARGUMENTS = SymfonyKernelEvents::CONTROLLER_ARGUMENTS;
    public const VIEW = SymfonyKernelEvents::VIEW;
    public const RESPONSE = SymfonyKernelEvents::RESPONSE;
    public const FINISH_REQUEST = SymfonyKernelEvents::FINISH_REQUEST;
    public const TERMINATE = SymfonyKernelEvents::TERMINATE;
}
