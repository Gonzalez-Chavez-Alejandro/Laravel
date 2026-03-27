<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Duda;
use App\Models\ReporteDuda;

class ReporteController extends Controller
{
    // Página principal del panel de reportes
    public function reporte()
    {
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $users = User::where('role', 'user')->count();

        $totalDudas = Duda::count();

        $respondidas = ReporteDuda::where('estado', 'respondida')
            ->distinct('duda_id')
            ->count('duda_id');

        $pendientes = ReporteDuda::where('estado', 'pendiente')
            ->distinct('duda_id')
            ->count('duda_id');

        $logs = ReporteDuda::with(['duda', 'user'])
            ->latest()
            ->take(15)
            ->get();

        $actividadPorDia = ReporteDuda::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->take(7)
            ->get();

        return view('admin.reportes.index', compact(
            'totalUsers',
            'admins',
            'users',
            'totalDudas',
            'respondidas',
            'pendientes',
            'logs',
            'actividadPorDia'
        ));
    }

    // Nueva vista de informe completo exportable
    public function exportar()
{
    // 🔹 Cargamos los mismos datos que en el dashboard
    $totalUsers = User::count();
    $admins = User::where('role', 'admin')->count();
    $users = User::where('role', 'user')->count();

    $totalDudas = Duda::count();

    $respondidas = ReporteDuda::where('estado', 'respondida')
        ->distinct('duda_id')
        ->count('duda_id');

    $pendientes = ReporteDuda::where('estado', 'pendiente')
        ->distinct('duda_id')
        ->count('duda_id');

    $logs = ReporteDuda::with(['duda', 'user'])
        ->latest()
        ->get(); // aquí mostramos todos los logs para el informe

    $actividadPorDia = ReporteDuda::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
        ->groupBy('fecha')
        ->orderBy('fecha', 'desc')
        ->get();

    // 🔹 Retornamos la vista nueva
    return view('admin.reportes.exportar', compact(
        'totalUsers',
        'admins',
        'users',
        'totalDudas',
        'respondidas',
        'pendientes',
        'logs',
        'actividadPorDia'
    ));
}
}