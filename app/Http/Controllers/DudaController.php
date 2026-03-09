<?php

namespace App\Http\Controllers;

use App\Models\Duda;
use Illuminate\Http\Request;

class DudaController extends Controller
{
    public function index()
    {
        $dudas = Duda::all();
        return view('dudas.index', compact('dudas'));
    }

    public function create()
    {
        return view('dudas.create');
    }

   public function store(Request $request)
{
    // Validación
    $request->validate([
        'titulo_categoria' => 'required|string',
        'descripcion.*'    => 'required|string',
        'imagen.*'         => 'nullable|image',
        'layout_bloque.*'  => 'required|in:caso1,caso2,caso3',
    ]);

    $descripciones = $request->input('descripcion'); // array de textos
    $layouts = $request->input('layout_bloque');      // array de layouts por bloque
    $imagenes = [];

    // Subida de imágenes
    if ($request->hasFile('imagen')) {
        foreach ($request->file('imagen') as $file) {
            if ($file) {
                $imagenes[] = $file->store('dudas', 'public');
            } else {
                $imagenes[] = null;
            }
        }
    }

    // Si hay menos imágenes que descripciones, rellenamos null
    for ($i = count($imagenes); $i < count($descripciones); $i++) {
        $imagenes[] = null;
    }

    // Crear el registro
    Duda::create([
        'titulo_categoria' => $request->titulo_categoria,
        'descripcion'      => $descripciones,
        'imagen'           => $imagenes,
        'layout'           => $layouts, // array de layouts por bloque
    ]);

    return redirect()->route('dudas.index');
}
}
