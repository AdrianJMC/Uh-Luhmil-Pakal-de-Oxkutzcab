<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $casts = [
        'approved' => 'boolean',
    ];

    protected $fillable = [
        'agrupacion_id',
        'nombre',
        'descripcion',
        'categoria',
        'precio',
        'stock',
        'unidad',
        'imagen',
        'estado',
        'motivo_rechazo',
    ];

    // Relación con la agrupación
    public function agrupacion()
    {
        return $this->belongsTo(Agrupacion::class);
    }

    // En App\Models\Producto
    public function getImageUrlAttribute()
    {
        // Si la imagen ya es una URL completa (de Cloudinary)
        if (filter_var($this->imagen, FILTER_VALIDATE_URL)) {
            return $this->imagen;
        }

        // Si prefieres usar la URL de Cloudinary con transformaciones
        return str_replace('/upload/', '/upload/c_limit,w_270,h_280,f_auto,q_auto/', $this->imagen);
    }
}
