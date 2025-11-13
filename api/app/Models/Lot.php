<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 
        'expiration_date', 
        'deposit_location_id'
    ];

    public function depositLocation()
    {
        return $this->belongsTo(DepositLocation::class);
    }

    public function MovementItems()
    {
        return $this->hasMany(MovementItem::class);
    }

}
