<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigouf',
        'name',
        'uf'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'uf', 'uf');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
