<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function getAll(array $relations = [])
    {
        return Supplier::with($relations)->get();
    }
}
