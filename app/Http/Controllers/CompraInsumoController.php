<?php

namespace App\Http\Controllers;

use App\Models\CompraInsumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraInsumoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $order = $request->input('order', 'desc');

        $compras = CompraInsumo::query()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->orderBy('fecha_compra', $order)
            ->paginate(10);

        $totalCompras = CompraInsumo::sum('total');

        return view('compras_insumos.index', compact('compras', 'totalCompras', 'search', 'order'));
    }

    public function create()
    {
        return view('compras_insumos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'producto' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'fecha_compra' => 'required|date',
            'estado' => 'required|in:pendiente,recibido,cancelado',
            'notas' => 'nullable|string',
        ]);

        $validated['total'] = $validated['cantidad'] * $validated['precio_unitario'];

        CompraInsumo::create($validated);

        return redirect()->route('compras-insumos.index')
            ->with('success', 'Compra registrada exitosamente.');
    }

    public function edit(CompraInsumo $compras_insumo)
    {
        return view('compras_insumos.edit', compact('compras_insumo'));
    }

    public function update(Request $request, CompraInsumi $compras_insumo)
    {
        $validated = $request->validate([
            'producto' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'proveedor' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'fecha_compra' => 'required|date',
            'estado' => 'required|in:pendiente,recibido,cancelado',
            'notas' => 'nullable|string',
        ]);

        $validated['total'] = $validated['cantidad'] * $validated['precio_unitario'];

        $compras_insumo->update($validated);

        return redirect()->route('compras-insumos.index')
            ->with('success', 'Compra actualizada exitosamente.');
    }

    public function destroy(CompraInsumo $compras_insumo)
    {
        $compras_insumo->delete();

        return redirect()->route('compras-insumos.index')
            ->with('success', 'Compra eliminada exitosamente.');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'compras' => 'required|array',
            'compras.*' => 'exists:compras_insumos,id',
        ]);

        CompraInsumo::whereIn('id', $request->compras)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Compras eliminadas exitosamente.'
        ]);
    }
}
