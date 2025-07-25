<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = ['user_id', 'items'];

    protected $casts = [
        'items' => 'array', // convierte automáticamente el JSON en array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
