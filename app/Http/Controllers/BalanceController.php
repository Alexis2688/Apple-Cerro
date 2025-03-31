<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function index(Request $request)
    {
        // Obtener mes y año de la solicitud o usar los actuales
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Calcular el balance
        $balance = Balance::calcularBalance($month, $year);

        return view('balance', [
            'totalVentas' => $balance->total_ventas,
            'totalCompras' => $balance->total_compras,
            'totalReparaciones' => $balance->total_reparaciones,
            'gananciaNeta' => $balance->ganancia_neta,
            'month' => $month,
            'year' => $year
        ]);
    }
}
