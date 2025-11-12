<?php

namespace App\Repositories\Eloquent;

use App\Models\Address;
use App\Repositories\BaseRepository;

class AddressRepository extends BaseRepository
{
    public function __construct(Address $model)
    {
        parent::__construct($model);
    }
}