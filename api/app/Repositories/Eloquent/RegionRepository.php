<?php

namespace App\Repositories\Eloquent;

use App\Models\Region;
use App\Repositories\BaseRepository;

class RegionRepository extends BaseRepository
{
    public function __construct(Region $model)
    {
        parent::__construct($model);
    }
}