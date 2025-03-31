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
        // Tarea para eliminar registros con más de 1 año de antigüedad
        $schedule->call(function () {
            $models = [
                \App\Models\Compra::class,
                \App\Models\Venta::class,
                \App\Models\Reparacion::class,
                // Agrega otros modelos si es necesario
            ];

            foreach ($models as $model) {
                $model::where('fecha', '<', now()->subYear())->delete();
                \Log::info("Limpieza de registros antiguos en: " . class_basename($model));
            }
        })->daily(); // Se ejecuta diariamente
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
