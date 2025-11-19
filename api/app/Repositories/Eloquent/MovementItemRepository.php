<?php

namespace App\Repositories\Eloquent;

use App\Models\MovementItem;
use App\Repositories\BaseRepository;

class MovementItemRepository extends BaseRepository
{
    public function __construct(MovementItem $model)
    {
        parent::__construct($model);
    }

    public function deleteByMovement(int $movementId)
    {
        return MovementItem::where('movement_id', $movementId)->delete();
    }
}