<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Api\NewsReader;
use App\Model\Entity\Item;
use App\Model\Entity\ItemList;
use Redis;
use function serialize;
use function unserialize;

final class ReadItemsRepository
{

    /**
     * ReadItemsRepository constructor.
     *
     * @param $newsReader
     */
    public function __construct(private NewsReader $newsReader)
    {
    }

    /**
     * getItems - Get all newest items. Store them in list and return whole list of objects
     *
     * @return array<\App\Repository\Items> The items
     */
    public function getItems(): array
    {
        $ids = $this->newsReader->getIdsForItems();
        $items = new ItemList;

        foreach ($ids as $id) {
            $items->add($this->getItem($id));
        }

        return $items->getAll();
    }

    /**
     * getItem check if data exists in cached redis, if we create new object item
     *
     * @param  int $id - identify number of
     * @return \App\Model\Entity\Item - Object with data of item
     */
    private function getItem(int $id): Item
    {
        $client = new Redis();
        $client->connect('redis');
        $result = $client->get((string)$id);

        if ($result) {
            $item = unserialize($result);
        } else {
            $item = new Item();
            $item->constructFromJson($this->newsReader->getItemJson($id));
            $client->setex((string)$id, 3600, serialize($item));
        }

        return $item;
    }

}
