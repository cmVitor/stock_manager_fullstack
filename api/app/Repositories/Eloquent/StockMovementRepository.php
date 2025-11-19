<?php

namespace App\Repositories\Eloquent;

use App\Models\StockMovement;
use App\Repositories\BaseRepository;

class StockMovementRepository extends BaseRepository
{
    public function __construct(StockMovement $model)
    {
        parent::__construct($model);
    }

    public function getAll(array $relations = [])
    {
        return StockMovement::with($relations)->get();
    }
}