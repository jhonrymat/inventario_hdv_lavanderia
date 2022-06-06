<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'blister',
        'unidad_blister',
        'unidades',
        'stock'
    ];
}
