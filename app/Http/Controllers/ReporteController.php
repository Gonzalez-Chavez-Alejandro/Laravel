<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Duda;
use App\Models\ReporteDuda;

class ReporteController extends Controller
{
    public function reporte()
    {
        // =========================
        // 👤 USUARIOS
        // =========================
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $users = User::where('role', 'user')->count();

        // =========================
        // ❓ DUDAS
        // =========================
        $totalDudas = Duda::count();

        // 🔥 SOLO CONTAR EL ESTADO MÁS RECIENTE POR DUDA
        $respondidas = ReporteDuda::where('estado', 'respondida')
            ->distinct('duda_id')
            ->count('duda_id');

        $pendientes = ReporteDuda::where('estado', 'pendiente')
            ->distinct('duda_id')
            ->count('duda_id');

        // =========================
        // 📊 HISTORIAL DE ACTIVIDAD
        // =========================
        $logs = ReporteDuda::with(['duda', 'user'])
            ->latest()
            ->take(15)
            ->get();

        // =========================
        // 📅 ACTIVIDAD POR DÍA (opcional)
        // =========================
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
}
