<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = ['titulo', 'texto', 'imagen_ruta', 'video_id', 'orden'];

    public function getIsVideoAttribute()
    {
        return !is_null($this->video_id);
    }
}
