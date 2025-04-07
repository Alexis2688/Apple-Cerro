<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CatalogoController extends Controller
{
    public function index()
    {
        $search = request('search');
        $disponibilidad = request('disponibilidad');

        $query = Catalogo::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");

                // Solo agregar categoría si existe la columna
                if (Schema::hasColumn('catalogos', 'categoria')) {
                    $q->orWhere('categoria', 'like', "%{$search}%");
                }
            });
        }

        if ($disponibilidad == 'disponible') {
            $query->where('stock', '>', 0);
        } elseif ($disponibilidad == 'agotado') {
            $query->where('stock', '<=', 0);
        }

        $catalogos = $query->latest()->get();

        return view('catalogos.index', compact('catalogos'));
    }

    public function create()
    {
        return view('catalogos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $imagenUrl = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('catalogos', 'public');
            $imagenUrl = '/storage/' . $imagenPath;
        }

        Catalogo::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'imagen_url' => $imagenUrl
        ]);

        return redirect()->route('catalogos.index')
            ->with('success', 'Producto creado exitosamente');
    }

    public function show(Catalogo $catalogo)
    {
        return view('catalogos.show', compact('catalogo'));
    }

    public function edit(Catalogo $catalogo)
    {
        return view('catalogos.edit', compact('catalogo'));
    }

    public function update(Request $request, Catalogo $catalogo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion
        ];

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($catalogo->imagen_url) {
                $oldImagePath = str_replace('/storage/', '', $catalogo->imagen_url);
                \Storage::disk('public')->delete($oldImagePath);
            }

            $imagenPath = $request->file('imagen')->store('catalogos', 'public');
            $data['imagen_url'] = '/storage/' . $imagenPath;
        }

        $catalogo->update($data);

        return redirect()->route('catalogos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Catalogo $catalogo)
    {
        // Eliminar imagen asociada si existe
        if ($catalogo->imagen_url) {
            $imagenPath = str_replace('/storage/', '', $catalogo->imagen_url);
            \Storage::disk('public')->delete($imagenPath);
        }

        $catalogo->delete();

        return redirect()->route('catalogos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
