<?php

namespace App\Repositories\Eloquent;

use App\Models\Lot;
use App\Repositories\BaseRepository;

class LotRepository extends BaseRepository
{
    public function __construct(Lot $model)
    {
        parent::__construct($model);
    }

    public function with(array $relations)
    {
        return $this->model->with($relations);
    }
}
