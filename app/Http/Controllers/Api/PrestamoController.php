<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class PrestamoController extends Controller
{
    public function index()
    {
        return response()->json(Prestamo::with(['usuario', 'libros'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date',
            'libros' => 'array',
            'libros.*' => 'exists:Libros,id'
        ]);

        $prestamo = Prestamo::create($request->all());

        if ($request->has('libros')) {
            $prestamo->libros()->attach($request->libros);
        }

        return response()->json($prestamo->load(['usuario', 'libros']), 201);
    }

    public function show($id)
    {
        $prestamo = Prestamo::with(['usuario', 'libros'])->find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($prestamo);
    }

    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'id_usuario' => 'exists:users,id',
            'fecha_prestamo' => 'date',
            'fecha_devolucion' => 'nullable|date',
            'libros' => 'array',
            'libros.*' => 'exists:Libros,id'
        ]);

        $prestamo->update($request->all());

        if ($request->has('libros')) {
            $prestamo->libros()->sync($request->libros);
        }

        return response()->json($prestamo->load(['usuario', 'libros']));
    }

    public function destroy($id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $prestamo->libros()->detach();
        $prestamo->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
