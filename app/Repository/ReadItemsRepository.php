<?php


namespace App\Repository;

use App\Api\NewsReader;
use App\Model\Entity\Item;
use App\Model\Entity\ItemList;
use Redis;
class ReadItemsRepository
{

    private $newsReader;

    /**
     * ReadItemsRepository constructor.
     * @param $newsReader
     */
    public function __construct(NewsReader $newsReader)
    {
        $this->newsReader = $newsReader;
    }

    /**
     * getItem check if data exists in cached redis, if we create new object item
     *
     * @param string $id - identify number of
     * @return Item - Object with data of item
     */
    private function getItem(string $id): Item
    {
        $client = new Redis();
        $client->connect('redis');
        $result = $client->get($id);
        if($result){
            $item = unserialize($result);
        }else{
            $item = new Item();
            $item->constructFromJson($this->newsReader->getItemJson($id));
            $client->setex($id,3600, serialize($item));
        }
        return $item;
    }

    /**
     * getItems - Get all newest items. Store them in list and return whole list of objects
     *
     * @return Items[] The items
     */
    public function getItems():array
    {
        $ids = $this->newsReader->getIdsForItems();
        $items = new ItemList();
        foreach ($ids as $id){
            $items->add($this->getItem($id));
        }
        return $items->getAll();

    }
}