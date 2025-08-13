<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agrupacion extends Authenticatable
{
    use Notifiable;

    protected $table = 'agrupaciones';
    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'nombre_agrupacion',
        'nombre_representante',
        'email_representante',
        'curp',
        'rfc_agrupacion',
        'direccion_agrupacion',
        'superficie_cosecha',
        'tipo_suelo',
        'num_trabajadores',
        'tipo_maquinaria',
        'horas_trabajo',
        'certificaciones',
        'fecha_inicio',
        'fecha_cosecha',
        'estado', // para la aprobación (pendiente, aprobada, rechazada)
        'password', // 👈🏻 AGREGA ESTA LÍNEA
    ];

    protected $casts = [
        'certificaciones' => 'array',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
