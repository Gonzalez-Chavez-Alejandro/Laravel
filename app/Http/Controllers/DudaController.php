<?php

namespace App\Http\Controllers;

use App\Models\Duda;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use App\Models\ReporteDuda;
use Illuminate\Support\Facades\Auth;

class DudaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $dudas = Duda::when($buscar, function ($query, $buscar) {
            $query->where('titulo_categoria', 'like', "%{$buscar}%");
        })
            ->paginate(7)
            ->appends(['buscar' => $buscar]);

        return view('admin.dudas.index', compact('dudas', 'buscar'));
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

        // ✅ CREAR DUDA
        $duda = Duda::create([
            'titulo_categoria' => $request->titulo_categoria,
            'descripcion'      => $descripciones,
            'imagen'           => $imagenes,
            'layout'           => $layouts,
        ]);

        // 🔥 REGISTRO INICIAL
        ReporteDuda::create([
            'duda_id' => $duda->id,
            'estado'  => 'pendiente',
            'accion'  => 'creado',
            'user_id' => Auth::id(),
            'titulo'  => $duda->titulo_categoria
        ]);

        return redirect()->route('admin.dudas.index')
            ->with('created', 'Duda guardada correctamente');
    }

    public function show(Duda $duda)
    {
        return view('admin.dudas.show', compact('duda'));
    }

    public function edit(Duda $duda)
    {
        return view('admin.dudas.edit', compact('duda'));
    }

    public function update(Request $request, Duda $duda)
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
                $imagenes[$index] = $duda->imagen[$index] ?? null;
            }
        }

        // ✅ ACTUALIZAR DUDA
        $duda->update([
            'titulo_categoria' => $request->titulo_categoria,
            'descripcion'      => array_values($descripciones),
            'imagen'           => array_values($imagenes),
            'layout'           => array_values($layouts),
        ]);

        // 🔥 ACTUALIZAR ESTADO
        ReporteDuda::where('duda_id', $duda->id)
            ->update(['estado' => 'respondida']);

        // 🔥 HISTORIAL
        ReporteDuda::create([
            'duda_id' => $duda->id,
            'accion'  => 'editado',
            'user_id' => Auth::id(),
            'titulo'  => $duda->titulo_categoria
        ]);

        return redirect()->route('admin.dudas.index')
            ->with('updated', 'Duda actualizada correctamente');
    }

    public function destroy($id)
    {
        $duda = Duda::findOrFail($id);

        
        ReporteDuda::create([
            'duda_id' => $duda->id,
            'user_id' => Auth::id(),
            'titulo' => $duda->titulo_categoria,
            'estado' => 'pendiente', // opcional
            'accion' => 'eliminado'
        ]);

        // 🔥 ELIMINAR
        $duda->delete();

        return redirect()->route('admin.dudas.index')
            ->with('deleted', 'Duda eliminada correctamente');
    }
}
