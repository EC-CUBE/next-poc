<?php

namespace Eccube\ORM\Pager;

use Eccube\ORM\QueryBuilder;
use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @see \Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ORM\QueryBuilderSubscriber
 */
class QueryBuilderSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if ($event->target instanceof QueryBuilder) {
            // change target into query
            $event->target = $event->target->getQuery();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 10/*make sure to transform before any further modifications*/],
        ];
    }
}
