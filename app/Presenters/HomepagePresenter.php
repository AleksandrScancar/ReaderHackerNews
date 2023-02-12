<?php

declare(strict_types = 1);

namespace App\Presenters;

use App\Repository\ReadItemsRepository;
use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    /**
     * HomepagePresenter constructor.
     */
    public function __construct(private ReadItemsRepository $readItemsRepository)
    {
    }


    public function actionDefault(): void
    {
        $this->template->items = $this->readItemsRepository->getItems();
    }

}
