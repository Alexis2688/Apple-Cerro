<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Reparacion;
use App\Models\CompraInsumo; // <-- Nuevo modelo añadido

class EliminarRegistrosAntiguos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $fechaLimite = now()->subYear();

        // Eliminar registros antiguos de cada modelo
        $this->eliminarDeModelo(Compra::class, 'fecha', $fechaLimite);
        $this->eliminarDeModelo(Venta::class, 'fecha', $fechaLimite);
        $this->eliminarDeModelo(Reparacion::class, 'fecha', $fechaLimite);
        $this->eliminarDeModelo(CompraInsumo::class, 'fecha_compra', $fechaLimite); // <-- Nueva línea

        Log::info('Eliminación de registros antiguos completada');
    }

    protected function eliminarDeModelo($modelo, $campoFecha, $fechaLimite)
    {
        $eliminados = $modelo::where($campoFecha, '<', $fechaLimite)->delete();

        Log::info(sprintf(
            "Eliminados %d registros de %s (campo: %s)",
            $eliminados,
            class_basename($modelo),
            $campoFecha
        ));
    }
}
