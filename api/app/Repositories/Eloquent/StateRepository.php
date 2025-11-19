<?php

namespace App\Repositories\Eloquent;

use App\Models\State;
use App\Repositories\BaseRepository;

class StateRepository extends BaseRepository
{
    public function __construct(State $model)
    {
        parent::__construct($model);
    }
}