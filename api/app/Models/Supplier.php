<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address_id'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function movementItems()
    {
        return $this->hasMany(MovementItem::class);
    }
}
