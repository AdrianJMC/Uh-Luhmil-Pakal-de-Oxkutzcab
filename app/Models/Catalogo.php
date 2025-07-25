<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $fillable = ['nombre', 'imagen_url', 'imagen_public_id'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria', 'nombre');
    }

    public function agrupaciones()
    {
        return $this->hasManyThrough(
            Agrupacion::class,
            Producto::class,
            'categoria', // FK en Producto
            'id',        // FK en Agrupacion
            'nombre',    // LK en Catalogo
            'agrupacion_id' // LK en Producto
        )->select('agrupaciones.id', 'agrupaciones.nombre_agrupacion', 
                'agrupaciones.nombre_representante', 'agrupaciones.email');
    }
}