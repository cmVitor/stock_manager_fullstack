<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'min_quantity',
        'nutrition_facts',
        'unit_id',
        'brand_id',
        'category_id'
    ];

    protected $casts = [
        'nutritional_info' => 'array',
    ];

    public function unit()
    {
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function movementItems()
    {
        return $this->hasMany(MovementItem::class);
    }
}
