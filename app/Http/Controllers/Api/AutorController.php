<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return response()->json(Autor::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        $autor = Autor::create($request->all());
        return response()->json($autor, 201);
    }

    public function show($id)
    {
        $autor = Autor::find($id);
        if (!$autor) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($autor);
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::find($id);
        if (!$autor) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $request->validate([
            'nombre' => 'string|max:255'
        ]);

        $autor->update($request->all());
        return response()->json($autor);
    }

    public function destroy($id)
    {
        $autor = Autor::find($id);
        if (!$autor) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $autor->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
