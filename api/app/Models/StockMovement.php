<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'movement_type',
        'movement_date',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movementItems(){
        return $this->hasMany(MovementItem::class);
    }
}
