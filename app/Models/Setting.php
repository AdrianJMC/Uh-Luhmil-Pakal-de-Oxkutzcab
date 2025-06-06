<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key','value'];

    /**
     * Devuelve el valor de un ajuste o $default si no existe.
     */
    public static function getValue(string $key, $default = null)
    {
        return static::where('key', $key)
                     ->value('value')
                 ?? $default;
    }

    /**
     * Guarda o actualiza un ajuste.
     */
    public static function setValue(string $key, $value)
    {
        return static::updateOrCreate(
            ['key'   => $key],
            ['value' => $value]
        );
    }
}
