<?php

namespace App\Services;

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        // Desactiva SSL sólo en entorno local
        $verifySSL = !app()->environment('local');

        $guzzleClient = new Client([
            'verify' => $verifySSL // 👈🏼 esta línea es clave
        ]);

        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.api_key'));

        $this->apiInstance = new TransactionalEmailsApi($guzzleClient, $config);
    }

    public function enviarNotificacionDesdeBlade($agrupacion, string $tipo)
    {
        $html = view('emails.notificacion-agrupacion', [
            'agrupacion' => $agrupacion,
            'tipo' => $tipo
        ])->render();

        $emailData = new \SendinBlue\Client\Model\SendSmtpEmail([
            'subject' => 'Estado de tu registro como agrupación',
            'sender' => ['name' => 'Uh Luhmil Pakal', 'email' => 'derrapo24@gmail.com'],
            'to' => [[
                'email' => $agrupacion->email_representante,
                'name' => $agrupacion->nombre_representante
            ]],
            'htmlContent' => $html
        ]);

        $this->apiInstance->sendTransacEmail($emailData);
    }
    
    public function correosEnviadosHoy(): int
    {
        return \App\Models\EmailPendiente::whereDate('send_at', now()->toDateString())->count();
    }
}
