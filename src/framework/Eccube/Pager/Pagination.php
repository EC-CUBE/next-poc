<?php

namespace Eccube\Pager;

use Knp\Component\Pager\Pagination\PaginationInterface;

class Pagination implements \Iterator, \Countable, \ArrayAccess
{
    private PaginationInterface $pagination;

    public function __construct(PaginationInterface $pagination)
    {
        $this->pagination = $pagination;
    }

    public function offsetExists($offset): bool
    {
        return $this->pagination->offsetExists($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->pagination->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->pagination->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->pagination->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->pagination->count();
    }

    public function setCurrentPageNumber(int $pageNumber): void
    {
        $this->pagination->setCurrentPageNumber($pageNumber);
    }

    public function getCurrentPageNumber(): int
    {
        return $this->pagination->getCurrentPageNumber();
    }

    public function setItemNumberPerPage(int $numItemsPerPage): void
    {
        $this->pagination->setItemNumberPerPage($numItemsPerPage);
    }

    public function getItemNumberPerPage(): int
    {
        return $this->pagination->getItemNumberPerPage();
    }

    public function setTotalItemCount(int $numTotal): void
    {
        $this->pagination->setTotalItemCount($numTotal);
    }

    public function getTotalItemCount(): int
    {
        return $this->pagination->getTotalItemCount();
    }

    public function setItems(iterable $items): void
    {
        $this->pagination->setItems($items);
    }

    public function getItems(): iterable
    {
        return $this->pagination->getItems();
    }

    public function setPaginatorOptions(array $options): void
    {
        $this->pagination->setPaginatorOptions($options);
    }

    public function getPaginatorOption(string $name)
    {
        $this->pagination->getPaginatorOption($name);
    }

    public function setCustomParameters(array $parameters): void
    {
        $this->pagination->setCustomParameters($parameters);
    }

    public function getCustomParameter(string $name)
    {
        return $this->pagination->getCurrentPageNumber($name);
    }

    public function getRoute(): ?string
    {
        return $this->pagination->getRoute();
    }

    public function getParams(): array
    {
        return $this->pagination->getParams();
    }

    public function isSorted($key = null, array $params = []): bool
    {
        return $this->pagination->isSorted($key, $params);
    }

    public function getPaginationData(): array
    {
        return $this->pagination->getPaginationData();
    }

    public function getPaginatorOptions(): ?array
    {
        return $this->pagination->getPaginatorOptions();
    }

    public function getCustomParameters(): ?array
    {
        return $this->pagination->getCustomParameters();
    }

    public function current(): mixed
    {
        return $this->pagination->current();
    }

    public function next(): void
    {
        $this->pagination->next();
    }

    public function key(): mixed
    {
        return $this->pagination->key();
    }

    public function valid(): bool
    {
        return $this->pagination->valid();
    }

    public function rewind(): void
    {
        $this->pagination->rewind();
    }
}
