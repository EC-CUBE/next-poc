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
        if ($event->target instanceof Query) {
            $event->target = $this->convertQuery($event->target);
        }
        if ($event->target instanceof QueryBuilder) {
            $event->target = $this->convertQuery($event->target->getQuery());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 10/*make sure to transform before any further modifications*/],
        ];
    }

    private function convertQuery(Query $query)
    {
        $ref = new \ReflectionClass(Query::class);
        return $ref->getProperty('query')->getValue($query);
    }
}
