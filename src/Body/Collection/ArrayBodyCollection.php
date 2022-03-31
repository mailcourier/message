<?php

declare(strict_types=1);

namespace Postboy\Message\Body\Collection;

use Postboy\Contract\Message\Body\BodyInterface;
use Postboy\Contract\Message\Body\Collection\BodyCollectionInterface;
use Postboy\Contract\Message\Exception\CanNotRemoveLastElement;
use RuntimeException;

class ArrayBodyCollection implements BodyCollectionInterface
{
    private int $index = 0;
    private int $cursor = 0;
    /**
     * @var BodyInterface[]
     */
    private array $items = [];

    final public function __construct(BodyInterface $body)
    {
        $this->add($body);
    }

    /**
     * @inheritDoc
     */
    final public function add(BodyInterface $body): void
    {
        foreach ($this->items as $item) {
            if ($item === $body) {
                return;
            }
        }
        $this->items[$this->index] = $body;
        $this->index++;
    }

    /**
     * @inheritDoc
     */
    final public function remove(BodyInterface $body): void
    {
        if ($this->count() === 1) {
            throw new CanNotRemoveLastElement('can not remove last element');
        }
        foreach ($this->items as $k => $item) {
            if ($item === $body) {
                unset($this->items[$k]);
            }
        }
    }

    /**
     * @inheritDoc
     */
    final public function current(): BodyInterface
    {
        if (!$this->valid()) {
            throw new RuntimeException('no current element');
        }
        return $this->items[$this->cursor];
    }

    /**
     * @inheritDoc
     */
    final public function next(): void
    {
        do {
            $this->cursor++;
        } while (!array_key_exists($this->cursor, $this->items) && $this->cursor <= $this->index);
    }

    /**
     * @inheritDoc
     */
    final public function key(): int
    {
        return $this->cursor;
    }

    /**
     * @inheritDoc
     */
    final public function valid(): bool
    {
        return array_key_exists($this->cursor, $this->items);
    }

    /**
     * @inheritDoc
     */
    final public function rewind(): void
    {
        $this->cursor = -1;
        $this->next();
    }

    /**
     * @inheritDoc
     */
    final public function count(): int
    {
        return count($this->items);
    }
}
