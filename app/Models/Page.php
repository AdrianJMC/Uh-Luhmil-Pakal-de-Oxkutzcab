<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    public const SLUG_HOME = 'home';
    public const SLUG_QUIENES = 'quienes-somos';

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
