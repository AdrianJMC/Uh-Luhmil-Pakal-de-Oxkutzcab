<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    // Campos permitidos para asignación masiva
    protected $fillable = [
        'titulo',
        'descripcion',
        'orden',
        'imagen_ruta',
    ];
}
