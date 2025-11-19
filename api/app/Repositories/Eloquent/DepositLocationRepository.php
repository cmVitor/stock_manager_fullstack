<?php

namespace App\Repositories\Eloquent;

use App\Models\DepositLocation;
use App\Repositories\BaseRepository;

class DepositLocationRepository extends BaseRepository
{
    public function __construct(DepositLocation $model)
    {
        parent::__construct($model);
    }
}