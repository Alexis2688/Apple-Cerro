<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index()
    {
        $catalogos = Catalogo::latest()->paginate(10);
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
            'descripcion' => 'required|string',
            'imagen' => 'nullable|mimes:jpg,png,webp'
        ]);

        $nombre = null;
        if ($request->hasFile('imagen')) {
            $nombre = $request->file('imagen')->store('menu', 'public');
        }

        Catalogo::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'imagen_url' => $nombre ? '/storage/' . $nombre : null
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
            'descripcion' => 'required|string',
            'imagen' => 'nullable|mimes:jpg,png,webp'
        ]);

        $nombre = $catalogo->imagen_url; // Por defecto la imagen actual

        if ($request->hasFile('imagen')) {
            $nuevo = $request->file('imagen')->store('menu', 'public');
            $nombre = '/storage/' . $nuevo;
        }

        $catalogo->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'imagen_url' => $nombre
        ]);

        return redirect()->route('catalogos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Catalogo $catalogo)
    {
        $catalogo->delete();
        return redirect()->route('catalogos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
