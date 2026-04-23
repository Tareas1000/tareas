<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        return response()->json(Libro::with(['categoria', 'autores'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'año_publicacion' => 'required|integer',
            'id_categoria' => 'required|exists:Categorias,id',
            'autores' => 'array',
            'autores.*' => 'exists:Autores,id'
        ]);

        $libro = Libro::create($request->all());

        if ($request->has('autores')) {
            $libro->autores()->attach($request->autores);
        }

        return response()->json($libro->load(['categoria', 'autores']), 201);
    }

    public function show($id)
    {
        $libro = Libro::with(['categoria', 'autores'])->find($id);
        if (!$libro) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($libro);
    }

    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);
        if (!$libro) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'titulo' => 'string|max:255',
            'año_publicacion' => 'integer',
            'id_categoria' => 'exists:Categorias,id',
            'autores' => 'array',
            'autores.*' => 'exists:Autores,id'
        ]);

        $libro->update($request->all());

        if ($request->has('autores')) {
            $libro->autores()->sync($request->autores);
        }

        return response()->json($libro->load(['categoria', 'autores']));
    }

    public function destroy($id)
    {
        $libro = Libro::find($id);
        if (!$libro) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $libro->autores()->detach();
        $libro->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
