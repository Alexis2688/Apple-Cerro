<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Reparacion;
use DB;

class VentaController extends Controller
{
    public function inicio()
    {
        // Calcular el total de ventas
        $totalVentas = Venta::sum(DB::raw('precio_venta * cantidad'));

        $totalCompras = DB::table('compras')->sum('total');

        // Calcular el total de reparaciones
        $totalReparaciones = DB::table('reparaciones')->sum('costo');


        // Calcular el balance total
        $balanceTotal = $totalVentas + $totalReparaciones - $totalCompras;

        // Calcular las operaciones del día
        $operacionesHoy = DB::table('ventas')
            ->whereDate('created_at', now()->toDateString())
            ->count() + DB::table('reparaciones')
            ->whereDate('created_at', now()->toDateString())
            ->count();

        // Pasar los datos a la vista
        return view('inicio', compact('totalVentas','totalCompras', 'totalReparaciones', 'balanceTotal', 'operacionesHoy'));
    }

    public function index(Request $request)
{
    // Obtener las ventas paginadas
    $ventas = Venta::paginate(10);

    // Calcular el total de ventas
    $totalVentas = Venta::sum(DB::raw('precio_venta * cantidad'));

    // Consultas adicionales para facturación diaria y filtros
    $search = $request->input('search');
    $order = $request->input('order', 'desc');

    // Consulta para obtener las ventas filtradas
    $ventasQuery = Venta::query()->where('mostrar', true);

    if ($search) {
        $ventasQuery->where(function($query) use ($search) {
            $query->where('modelo', 'like', '%' . $search . '%')
                ->orWhereDate('fecha', 'like', '%' . $search . '%');
        });
    }

    // Obtener las ventas paginadas
    $ventas = $ventasQuery->orderBy('fecha', $order)->paginate(10);

    // Calcular la facturación por día
    $facturacionPorDia = Venta::selectRaw('DATE(fecha) as fecha, SUM(precio_venta * cantidad) as total')
        ->groupBy('fecha')
        ->orderBy('fecha', 'desc')
        ->get();

    // Pasar las variables a la vista
    return view('ventas.index', compact('ventas', 'totalVentas', 'facturacionPorDia'));
}


    public function create()
    {
        return view('ventas.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'modelo' => 'required|string|max:255',
        'estado' => 'required|in:nuevo,usado,reacondicionado',
        'precio_venta' => 'required|numeric|min:0',
        'cantidad' => 'required|integer|min:1',
        'fecha' => 'required|date'
    ]);

    try {
        $venta = Venta::create([
            'modelo' => $validated['modelo'],
            'estado' => $validated['estado'],
            'precio_venta' => $validated['precio_venta'],
            'cantidad' => $validated['cantidad'],
            'fecha' => $validated['fecha'],
            'total' => $validated['precio_venta'] * $validated['cantidad'],
            'stock_venta' => 'vendido',
        ]);

        return redirect()->route('ventas.index')
               ->with('success', 'Venta registrada exitosamente!');

    } catch (\Exception $e) {
        return back()->withInput()
               ->with('error', 'Error al registrar la venta: '.$e->getMessage());
    }
}



    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        return view('ventas.edit', compact('venta'));
    }

    public function update(Request $request, Venta $venta)
    {
        // Validar los datos de la venta
        $validated = $request->validate([
            'modelo' => 'required|string|max:255',
            'estado' => 'required|string',
            'precio_venta' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'required|date'
        ]);

        // Actualizar la venta
        $venta->update($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy(Venta $venta)
    {
        // Eliminar la venta
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }

    public function destroyMultiple(Request $request)
{
    $request->validate([
        'ventas' => 'required|array',
        'ventas.*' => 'required|integer|exists:ventas,id'
    ]);

    try {
        // Obtener el mes y año actual
        $mesActual = now()->month;
        $anioActual = now()->year;

        // Actualizar solo ventas del mes actual seleccionadas
        $count = Venta::whereIn('id', $request->ventas)
                     ->whereMonth('fecha', $mesActual)
                     ->whereYear('fecha', $anioActual)
                     ->update(['mostrar' => false]);

        return response()->json([
            'success' => true,
            'message' => "Se ocultaron {$count} ventas del mes actual",
            'count' => $count
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al ocultar ventas: '.$e->getMessage()
        ], 500);
    }
}
    public function facturacion(Request $request)
{
    $fecha = $request->get('fecha', now()->toDateString());

    // Obtener las ventas de la fecha seleccionada, agrupadas por fecha sin considerar la hora
    $facturacionPorDia = DB::table('ventas')
        ->select(DB::raw('DATE(fecha) as fecha'), DB::raw('SUM(precio_venta * cantidad) as total'))
        ->whereDate('fecha', $fecha)  // Asegurarse de comparar solo la fecha de 'fecha_creacion'
        ->groupBy(DB::raw('DATE(fecha)'))  // Agrupar por fecha sin hora
        ->get();

    return view('ventas.facturacion', compact('facturacionPorDia'));
}



    public function eliminarPorFecha($fecha)
    {
        // Eliminar ventas por fecha
        Venta::whereDate('fecha', $fecha)->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('ventas.facturacion')->with('success', 'Ventas eliminadas por fecha correctamente.');
    }
}
