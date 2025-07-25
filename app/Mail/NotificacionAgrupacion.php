<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionAgrupacion extends Mailable
{
    use Queueable, SerializesModels;

    public $agrupacion;
    public $tipo;

    public function __construct($agrupacion, $tipo)
    {
        $this->agrupacion = $agrupacion;
        $this->tipo = $tipo;
    }

    public function build()
    {
        return $this->subject('Estado de tu registro como agrupación')
            ->view('emails.notificacion-agrupacion');
    }
}
