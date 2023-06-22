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

namespace Eccube\Http;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListener implements EventSubscriberInterface
{
    public function onKernelView(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        if ($result instanceof Response) {
            $event->setResponse($result->getAdaptee());
        }
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::VIEW => ['onKernelView', 1000001]];
    }
}
