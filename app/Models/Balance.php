<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'total_ventas',
        'total_compras',
        'total_reparaciones',
        'ganancia_neta'
    ];

    // Calcular y guardar el balance mensual
    public static function calcularBalance($month, $year)
    {
        // Obtener o crear el registro de balance
        $balance = self::firstOrNew([
            'month' => $month,
            'year' => $year
        ]);

        // Aquí deberías implementar la lógica para calcular los totales
        // Esto es un ejemplo - ajusta según tus modelos reales
        $balance->total_ventas = \App\Models\Venta::whereMonth('fecha', $month)
                                    ->whereYear('fecha', $year)
                                    ->sum('total');

        $balance->total_compras = \App\Models\Compra::whereMonth('fecha', $month)
                                    ->whereYear('fecha', $year)
                                    ->sum('total');

        $balance->total_reparaciones = \App\Models\Reparacion::whereMonth('fecha', $month)
                                        ->whereYear('fecha', $year)
                                        ->sum('costo');

        $balance->ganancia_neta = ($balance->total_ventas + $balance->total_reparaciones) - $balance->total_compras;

        $balance->save();

        return $balance;
    }
}
