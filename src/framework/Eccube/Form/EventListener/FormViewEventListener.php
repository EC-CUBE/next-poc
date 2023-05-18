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

namespace Eccube\Form\EventListener;

use Eccube\Form\FormView;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class FormViewEventListener implements EventSubscriberInterface
{
    public function onKernelView(ViewEvent $event) {
        $result = $event->getControllerResult();
        foreach ($result as $key => $value) {
            if ($value instanceof FormView) {
                $result[$key] = $value->getAdaptee();
                $event->setControllerResult($result);
            }
            if (is_array($value)) {
                $result[$key] = array_map(function($e) {
                    return $e instanceof FormView ? $e->getAdaptee() : $e;
                }, $value);;
                $event->setControllerResult($result);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::VIEW => ['onKernelView', 1000001]];
    }
}
