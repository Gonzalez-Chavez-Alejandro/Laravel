<?php

namespace App\Http\Controllers;

use App\Models\Duda;
use Illuminate\Http\Request;


class DudaVistaController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $dudas = Duda::where('titulo_categoria', 'like', "%$buscar%")
                      ->paginate(100);

        return view('dudas.index', compact('dudas'));
    }
}
