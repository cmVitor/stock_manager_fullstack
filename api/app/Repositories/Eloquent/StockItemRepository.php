<?php

namespace App\Repositories\Eloquent;

use App\Models\StockItem;
use App\Repositories\BaseRepository;

class StockItemRepository extends BaseRepository
{
    public function __construct(StockItem $model)
    {
        parent::__construct($model);
    }
}