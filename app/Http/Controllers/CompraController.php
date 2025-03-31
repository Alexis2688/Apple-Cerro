<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use DB;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        // Obtener las compras paginadas
        $compras = Compra::paginate(10);

        // Calcular el total de compras
        $totalCompras = DB::table('compras')->sum('total');

        // Consultas adicionales para facturación diaria y filtros
        $search = $request->input('search');
        $order = $request->input('order', 'desc');

        // Consulta para obtener las compras filtradas
        $comprasQuery = Compra::where('mostrar', true);

    // [Mantén todo el resto de tu código actual igual...]
    $search = $request->input('search');
    $order = $request->input('order', 'desc');

    if ($search) {
        $comprasQuery->where(function ($query) use ($search) {
            $query->where('producto', 'like', '%' . $search . '%')
                ->orWhereDate('fecha', 'like', '%' . $search . '%');
        });
    }

        $compras = $comprasQuery->orderBy('fecha', $order)->paginate(10);
        $totalCompras = $comprasQuery->sum('total');

        $facturacionPorDia = Compra::selectRaw('DATE(fecha) as fecha, SUM(precio * cantidad) as total')
            ->where('mostrar', true)
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();



        return view('compras.index', compact('compras', 'totalCompras', 'facturacionPorDia'));
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'modelo' => 'required|string|max:255',
        'proveedor' => 'required|string|max:255',
        'cantidad' => 'required|integer|min:1',
        'precio' => 'required|numeric|min:0',
        'estado' => 'required|string|max:255',
        'fecha' => 'required|date',
    ]);

    // Calculamos el total
    $total = $request->cantidad * $request->precio;
    // Guardamos la compra
    Compra::create([
        'modelo' => $request->modelo,
        'proveedor' => $request->proveedor,
        'cantidad' => $request->cantidad,
        'precio' => $request->precio,
        'estado' => $request->estado,
        'fecha' => $request->fecha,
        'notas' => $request->notas,  // Si es necesario
        'total' => $total,
    ]);

    return redirect()->route('compras.index')->with('success', 'Compra registrada con éxito');
}



    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        return view('compras.edit', compact('compra'));
    }

    public function update(Request $request, Compra $compra)
    {
        $validated = $request->validate([
            'producto' => 'required|string|max:255',
            'proveedor' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'required|date'
        ]);

        $compra->update($validated);

        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada exitosamente.');
    }

    public function destroyMultiple(Request $request)
{
    $request->validate([
        'compras' => 'required|array',
        'compras.*' => 'required|integer|exists:compras,id'
    ]);

    try {
        // Obtener el mes y año actual
        $mesActual = now()->month;
        $anioActual = now()->year;

        // Actualizar solo compras del mes actual seleccionadas
        $count = Compra::whereIn('id', $request->compras)
                     ->whereMonth('fecha', $mesActual)
                     ->whereYear('fecha', $anioActual)
                     ->update(['mostrar' => false]);

        return response()->json([
            'success' => true,
            'message' => "Se ocultaron {$count} compras del mes actual",
            'count' => $count
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al ocultar compras: '.$e->getMessage()
        ], 500);
    }
}

    public function facturacion(Request $request)
{
    $fecha = $request->get('fecha');

    $facturacionPorDia = DB::table('compras')
        ->select(DB::raw('DATE(fecha) as fecha'), DB::raw('SUM(total) as total'))
        ->when($fecha, function ($query) use ($fecha) {
            $query->whereDate('fecha', $fecha);
        })
        ->groupBy('fecha')
        ->orderBy('fecha', 'desc')
        ->get();

    return view('compras.facturacion', compact('facturacionPorDia'));
}


    public function eliminarPorFecha($fecha)
    {
        Compra::whereDate('fecha', $fecha)->delete();
        return redirect()->route('compras.facturacion')->with('success', 'Compras eliminadas por fecha correctamente.');
    }

}

