<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
     // Permitir masivamente estos campos
    protected $fillable = [
        'slug',
        'title',
        'content',
        'image',
        'image2',      // Imagen secundaria
        'image3',      // Imagen adicional
        'video_url',   // URL del vídeo
    ];

}
