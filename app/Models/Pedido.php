<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_cliente',
        'telefono',
        'folio',
        'total',
    ];

    // Relación con usuario (quien hace el pedido)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agrupacion()
    {
        return $this->belongsTo(\App\Models\Agrupacion::class);
    }

    public function productos()
    {
        return $this->hasMany(\App\Models\PedidoProducto::class);
    }
}
