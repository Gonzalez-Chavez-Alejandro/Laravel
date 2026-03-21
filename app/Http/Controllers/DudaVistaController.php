<?php

namespace App\Http\Controllers;

use App\Models\Duda;
use Illuminate\Http\Request;


class DudaVistaController extends Controller
{
    public function index(Request $request)
    {
        $dudas = Duda::paginate(1);

        return view('dudas.index', compact('dudas'));
    }
}
