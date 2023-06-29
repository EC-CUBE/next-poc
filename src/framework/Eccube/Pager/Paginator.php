<?php

namespace Eccube\Pager;

use Knp\Component\Pager\PaginatorInterface;

class Paginator
{
    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function paginate($target, int $page = 1, int $limit = null, array $options = [])
    {
        return new Pagination($this->paginator->paginate($target, $page, $limit, $options));
    }
}
