<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailPendiente extends Model
{
    protected $table = 'email_pendientes';

    protected $fillable = [
        'to',
        'subject',
        'body',
        'send_at',
        'enviado',
    ];

    protected $casts = [
        'send_at' => 'datetime',
        'enviado' => 'boolean',
    ];
}
