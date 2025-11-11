<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_movement_id',
        'product_id',
        'lot_id',
        'supplier_id',
        'quantity',
        'price'
    ];

    public function stockMovement()
    {
        return $this->belongsTo(StockMovement::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function batch()
    {
        return $this->belongsTo(Lot::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
