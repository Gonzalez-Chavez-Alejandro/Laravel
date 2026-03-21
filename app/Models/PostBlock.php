<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostBlock extends Model
{
    protected $fillable = [
        'post_id',
        'type',
        'content',
        'text',        // Importante: este campo debe estar aquí
        'position',
        'order'
    ];

    // Relación con Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}