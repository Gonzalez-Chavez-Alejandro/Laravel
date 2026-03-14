<?php

namespace App\Http\Controllers;

use App\Models\Duda;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

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

        // Crear instancia de Cloudinary
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        foreach ($descripciones as $index => $desc) {

            if ($request->hasFile("imagen.$index")) {

                $file = $request->file("imagen.$index");

                $upload = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
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

        return redirect()->route('dudas.index')
            ->with('success', 'Duda guardada correctamente');
    }

    public function show(Duda $duda)
    {
        return view('admin.dudas.show', compact('duda'));
    }
}