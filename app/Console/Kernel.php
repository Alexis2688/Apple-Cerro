<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registra los comandos Artisan personalizados.
     */
    protected $commands = [
        \App\Console\Commands\GenerateBalances::class, // Agrega aquí tus comandos personalizados
    ];

    /**
     * Define la programación de tareas.
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejecutar el job diariamente a la medianoche
        $schedule->job(new \App\Jobs\eliminarRegistrosAntiguos())
                ->daily()
                ->description('Eliminar registros con más de 1 año de antigüedad');
    }

    /**
     * Registra los comandos de la aplicación.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands'); // Carga automáticamente los comandos en app/Console/Commands
        require base_path('routes/console.php'); // Permite definir comandos en routes/console.php
    }

    protected $routeMiddleware = [
        // ... otros middlewares existentes
        'admin' => \App\Http\Middleware\CheckAdmin::class,
    ];
}


/* php artisan tinker
Psy Shell v0.12.8 (PHP 8.2.4 — cli) by Justin Hileman
> \App\Jobs\EliminarRegistrosAntiguos::dispatchSync();
= 0

>
 */
