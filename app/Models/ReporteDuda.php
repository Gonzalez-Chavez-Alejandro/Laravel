<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Duda;

class ReporteDuda extends Model
{
    protected $table = 'reporte_dudas';

    protected $fillable = [
        'duda_id',
        'user_id',
        'titulo',
        'estado',
        'accion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function duda()
    {
        return $this->belongsTo(Duda::class);
    }
}