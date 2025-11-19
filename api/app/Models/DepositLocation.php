<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'aisle',
        'shelf',
        'section'
    ];

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }
}
