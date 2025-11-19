<?php

namespace App\Repositories\Eloquent;

use App\Models\City;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function getByUf($uf)
    {
        return $this->model->where('uf', $uf)->orderBy('name')->get();;
    }
}