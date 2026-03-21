<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duda extends Model
{
    protected $fillable = [
        'titulo_categoria',
        'descripcion',
        'imagen',
        'layout'
    ];
    protected $casts = [
        'descripcion' => 'array',
        'imagen' => 'array',
        'layout'      => 'array',
    ];
}
