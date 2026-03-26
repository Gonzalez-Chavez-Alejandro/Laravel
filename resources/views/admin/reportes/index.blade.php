@extends('layouts.app_admin')
@section('title', 'Reportes')

@section('content')

<style>
    .contenedor-reportes {
        padding: 25px;
    }

    .grid-reportes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .card-reporte {
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-reporte:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .card-reporte h2 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #2d3748;
    }

    .numero {
        font-size: 28px;
        font-weight: bold;
        color: #1a202c;
    }

    .verde { color: #16a34a; }
    .rojo { color: #dc2626; }
    .azul { color: #2563eb; }
    .amarillo { color: #ca8a04; }

    .card-reporte ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .card-reporte li {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .titulo-principal {
        font-size: 28px;
        margin-bottom: 25px;
        font-weight: bold;
    }

    .accion {
        font-weight: bold;
        text-transform: capitalize;
    }

    .log-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .fecha {
        color: #6b7280;
        font-size: 12px;
    }
</style>

<div class="contenedor-reportes">

<h1 class="titulo-principal">📊 Panel de Reportes</h1>

<div class="grid-reportes">

    <div class="card-reporte">
        <h2>👤 Usuarios</h2>
        <p class="numero">{{ $totalUsers }}</p>
        <small>Totales</small>
    </div>

    <div class="card-reporte">
        <h2>🛡️ Admins</h2>
        <p class="numero azul">{{ $admins }}</p>
    </div>

    <div class="card-reporte">
        <h2>🙋 Usuarios</h2>
        <p class="numero">{{ $users }}</p>
    </div>

    <div class="card-reporte">
        <h2>❓ Temas</h2>
        <p class="numero">{{ $totalDudas }}</p>
    </div>

    <div class="card-reporte">
        <h2>⏳ Pendientes</h2>
        <p class="numero rojo">{{ $pendientes }}</p>
    </div>

</div>

<div class="card-reporte" style="margin-top: 25px;">
    <h2>🕒 Actividad reciente</h2>

    @if ($logs->isEmpty())
        <p>No hay actividad aún.</p>
    @else
        <ul>
            @foreach ($logs as $log)

                @php
                    $claseColor = match($log->accion) {
                        'creado' => 'verde',
                        'editado' => 'azul',
                        'eliminado' => 'rojo',
                        default => 'amarillo'
                    };

                    $icono = match($log->accion) {
                        'creado' => '🟢',
                        'editado' => '🔵',
                        'eliminado' => '🔴',
                        default => '⚪'
                    };
                @endphp

                <li class="log-item">

                    {{-- 🔥 ACCIÓN --}}
                    <span class="accion {{ $claseColor }}">
                        {{ $icono }} {{ ucfirst($log->accion) }}
                    </span>

                    {{-- 🔥 TÍTULO --}}
                    <div>
                        {{ $log->titulo ?? 'Sin título' }}
                    </div>

                    {{-- 🔥 USUARIO Y FECHA --}}
                    <small class="fecha">
                        👤 {{ optional($log->user)->name ?? 'Sistema' }} |
                        🕒 {{ $log->created_at->format('d M Y - h:i A') }}
                    </small>

                </li>

            @endforeach
        </ul>
    @endif
</div>

<div class="card-reporte" style="margin-top: 25px;">
    <h2>📅 Actividad por día</h2>

    @if ($actividadPorDia->isEmpty())
        <p>No hay datos.</p>
    @else
        <ul>
            @foreach ($actividadPorDia as $dia)
                <li>
                    <strong>{{ \Carbon\Carbon::parse($dia->fecha)->format('d M Y') }}</strong> →
                    <span class="amarillo">
                        {{ $dia->total }} acciones
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>


</div>
@endsection
