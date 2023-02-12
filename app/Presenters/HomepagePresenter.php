<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Repository\ReadItemsRepository;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    private $readItemsRepository;

    /**
     * HomepagePresenter constructor.
     * @param $readItemsRepository
     */
    public function __construct(ReadItemsRepository $readItemsRepository)
    {
        $this->readItemsRepository = $readItemsRepository;
    }

    public function actionDefault():void{
        $this->template->items = $this->readItemsRepository->getItems();
    }
}
