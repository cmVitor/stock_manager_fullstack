<?php

namespace App\Repositories\Eloquent;

use App\Models\MeasurementUnit;
use App\Repositories\BaseRepository;

class UnitRepository extends BaseRepository
{
    public function __construct(MeasurementUnit $model)
    {
        parent::__construct($model);
    }
}