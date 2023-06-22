<?php

namespace Eccube\ORM\Pager;

use Eccube\ORM\Query;
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
            $query = $event->target->getQuery();
            if ($query instanceof Query) {
                $ref = new \ReflectionClass(Query::class);
                $query = $ref->getProperty('query')->getValue($query);
            }
            // change target into query
            $event->target = $query;
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 10/*make sure to transform before any further modifications*/],
        ];
    }
}
