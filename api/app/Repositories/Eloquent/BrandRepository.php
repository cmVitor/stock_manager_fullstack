<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository
{
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }
}