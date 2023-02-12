<?php


namespace App\Model\Entity;

final class ItemList
{
    /**
     * @var Item[] The users
     */
    private array $list;

    /**
     * The constructor.
     *
     * @param Item ...$item items
     */
    public function __construct(Item ...$item)
    {
    }

    /**
     * Add item to list.
     *
     * @param Item $item
     *
     * @return void
     */
    public function add(Item $item): void
    {
        $this->list[] = $item;
    }

    /**
     * Get all items.
     *
     * @return Item[] The items
     */
    public function getAll(): array
    {
        return $this->list;
    }
}
