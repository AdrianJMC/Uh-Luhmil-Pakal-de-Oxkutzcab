<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Comandos personalizados (si Laravel no los detecta automáticamente).
     */
    protected $commands = [
        \App\Console\Commands\ProcesarEmailsPendientes::class,
    ];

    /**
     * Define el schedule de tareas.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:procesar-emails-pendientes')->dailyAt('07:00');
    }

    /**
     * Registra los comandos de consola.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
