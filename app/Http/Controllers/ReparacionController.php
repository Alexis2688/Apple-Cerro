<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reparacion;
use Carbon\Carbon;

class ReparacionController extends Controller
{
    // Mostrar lista de reparaciones
    public function index()
    {

        $reparaciones = Reparacion::where('mostrar', true)
                        ->orderBy('fecha', 'desc')
                        ->get();
        return view('reparaciones.index', compact('reparaciones'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('reparaciones.create');
    }

    // Guardar nueva reparación
    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string|max:255',
            'estado' => 'required|string|in:Pendiente,En proceso,Reparado',
            'fallas' => 'required|string|max:500',
            'costo' => 'required|numeric|min:0',
            'fecha' => 'required|date',
        ]);

        Reparacion::create($request->all());
        return redirect()->route('reparaciones.index')->with('success', 'Reparación registrada correctamente.');
    }

    // Mostrar detalles de una reparación
    public function show(Reparacion $reparacion)
    {
        return view('reparaciones.show', compact('reparacion'));
    }

    // Mostrar formulario de edición
        public function edit(Reparacion $reparacion)
    {
        return view('reparaciones.edit', compact('reparacion'));
    }

    // Actualizar reparación
        public function update(Request $request, Reparacion $reparacion)
    {
        $reparacion->update($request->all());
        return redirect()->route('reparaciones.index')->with('success', 'Reparación actualizada con éxito.');
    }

    // Eliminar reparación
    public function destroy(Reparacion $reparacion)
    {
        $reparacion->delete();
        return redirect()->route('reparaciones.index')->with('success', 'Reparación eliminada correctamente.');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'reparaciones' => 'required|array',
            'reparaciones.*' => 'required|integer|exists:reparaciones,id'
        ]);

        try {
            // Obtener el mes y año actual
            $mesActual = now()->month;
            $anioActual = now()->year;

            // Actualizar solo reparaciones del mes actual seleccionadas
            $count = Reparacion::whereIn('id', $request->reparaciones)
                     ->whereMonth('fecha', $mesActual)
                     ->whereYear('fecha', $anioActual)
                     ->update(['mostrar' => false]);

            return response()->json([
                'success' => true,
                'message' => "Se ocultaron {$count} reparaciones del mes actual",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al ocultar reparaciones: '.$e->getMessage()
            ], 500);
        }
    }
    
    public function facturacion(Request $request)
{
    $fechaSeleccionada = $request->get('fecha', now()->toDateString());

    $reparaciones = Reparacion::whereDate('fecha', $fechaSeleccionada)->get();

    $totalFacturado = $reparaciones->sum('costo');

    return view('reparaciones.facturacion', compact('fechaSeleccionada', 'reparaciones', 'totalFacturado'));
}

}
