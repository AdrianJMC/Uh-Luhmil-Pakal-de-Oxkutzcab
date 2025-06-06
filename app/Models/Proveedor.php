<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'edad',
        'nacionalidad',
        'curp',
        'rfc',
        'ubicacion',
        'superficie_cosecha',
        'tipo_suelo',
    ];
}
