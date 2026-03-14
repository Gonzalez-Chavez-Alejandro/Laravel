<?php

namespace App\Http\Controllers;

use App\Models\Duda;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DudaController extends Controller
{
    public function index()
    {
        $dudas = Duda::all();
        return view('admin.dudas.index', compact('dudas'));
    }

    public function create()
    {
        return view('admin.dudas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo_categoria' => 'required|string',

            'descripcion' => 'required|array',
            'descripcion.*' => 'required|string',

            'layout_bloque' => 'required|array',
            'layout_bloque.*' => 'required|in:caso1,caso2,caso3',

            'imagen.*' => 'nullable|image|max:2048',
        ]);

        $descripciones = $request->input('descripcion');
        $layouts = $request->input('layout_bloque');
        $imagenes = [];

        // Obtenemos los archivos del request
        $files = $request->file('imagen');

        foreach ($descripciones as $index => $desc) {
            // Buscamos el archivo específicamente por su posición en el array enviado
            if ($request->hasFile("imagen.$index")) {
                $upload = Cloudinary::uploadApi()->upload(
                    $request->file("imagen.$index")->getRealPath(),
                    ['folder' => 'dudas']
                );
                $imagenes[$index] = $upload['secure_url'];
            } else {
                $imagenes[$index] = null;
            }
        }


        Duda::create([
            'titulo_categoria' => $request->titulo_categoria,
            'descripcion'      => $descripciones,
            'imagen'           => $imagenes,
            'layout'           => $layouts,
        ]);

        return redirect()->route('dudas.index')->with('success', 'Duda guardada correctamente');
    }
    public function show(Duda $duda)
    {
        return view('admin.dudas.show', compact('duda'));
    }

}
