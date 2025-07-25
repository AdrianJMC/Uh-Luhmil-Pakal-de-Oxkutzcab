<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmailPendiente;
use App\Services\BrevoService;

class ProcesarEmailsPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:procesar-emails-pendientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = EmailPendiente::whereDate('send_at', now()->toDateString())->get();
        $brevo = new BrevoService();

        foreach ($emails as $email) {
            \Illuminate\Support\Facades\Mail::raw($email->body, function ($message) use ($email) {
                $message->to($email->to)
                    ->subject($email->subject)
                    ->setBody($email->body, 'text/html');
            });

            $email->delete();
        }
    }
}
