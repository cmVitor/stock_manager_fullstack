<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'logradouro',
        'number',
        'complement',
        'city_id',
        'bairro',
        'cep'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }
}
