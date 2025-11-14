<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'product',
        'lot',
        'expiration_date',
        'balance',
        'min_quantity',
        'status'
    ];
}
