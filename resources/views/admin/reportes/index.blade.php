@extends('layouts.app_admin')
@section('title', 'Reportes Avanzados')

@section('content')

<div class="contenedor-reportes">
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 0;">📊 Panel de Reportes</h1>
    </div>

    <div class="grid-stats">
        <div class="stat-card">
            <span class="label">Usuarios Totales</span>
            <div class="value">{{ $totalUsers }}</div>
            <div class="progress-mini">
                <div class="progress-bar" style="width: 100%; background: var(--success)"></div>
            </div>
            <i class="fas fa-users stat-icon-bg"></i>
        </div>

        <div class="stat-card">
            <span class="label">Administradores</span>
            <div class="value" style="color: var(--primary)">{{ $admins }}</div>
            <div class="progress-mini">
                <div class="progress-bar"
                    style="width: {{ $totalUsers > 0 ? ($admins / $totalUsers) * 100 : 0 }}%; background: var(--primary)">
                </div>
            </div>
            <i class="fas fa-user-shield stat-icon-bg"></i>
        </div>

        <div class="stat-card">
            <span class="label">Temas / Dudas</span>
            <div class="value" style="color: var(--info)">{{ $totalDudas }}</div>
            <div class="progress-mini">
                <div class="progress-bar" style="width: 60%; background: var(--info)"></div>
            </div>
            <i class="fas fa-comments stat-icon-bg"></i>
        </div>

        <div class="stat-card stat-card-button" onclick="window.print()">
            <i class="fas fa-file-invoice" style="font-size: 2rem; color: var(--primary); margin-bottom: 10px;"></i>
            <span style="font-weight: 700; color: #1e293b; text-transform: uppercase; font-size: 0.8rem;">Generar
                Informe</span>
            <small style="color: #94a3b8;">Click para imprimir</small>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Actividad Reciente -->
        <div class="panel-moderno" id="p-actividad">
            <div class="panel-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-bolt" style="color: var(--warning)"></i>
                    <h2 style="margin:0; font-size:1.1rem; font-weight: 700;">Actividad Reciente</h2>
                </div>
                <button onclick="expandirPanel('p-actividad')" style="background:none; border:none; cursor:pointer;">
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
            </div>
            <div class="panel-body-collapse">
                <div style="overflow-x: auto;">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Autor</th>
                                <th>Tiempo</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Mostramos solo los primeros 5 logs --}}
                            @foreach ($logs->take(5) as $log)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b;">{{ $log->titulo }}</div>
                                        <span style="font-size: 0.7rem; font-weight: 800; color: {{ $log->accion == 'creado' ? 'var(--success)' : ($log->accion == 'editado' ? 'var(--primary)' : 'var(--danger)') }}">
                                            ● {{ strtoupper($log->accion) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div class="user-avatar">{{ substr($log->user->name ?? 'S', 0, 1) }}</div>
                                            <span style="font-weight: 500; font-size: 0.9rem;">{{ $log->user->name ?? 'Sistema' }}</span>
                                        </div>
                                    </td>
                                    <td style="color: #64748b;">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Botón Ver Más solo si hay más de 5 logs --}}
                    @if($logs->count() > 5)
                        <div style="text-align:center; margin-top: 10px;">
                            <button id="verMasLogs" onclick="verMas()" style="padding: 6px 12px; border-radius:6px; border:none; background: var(--primary); color:#fff; cursor:pointer;">
                                Ver más
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pulso Diario -->
        <div class="panel-moderno" id="p-pulso">
            <div class="panel-header">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-calendar-check" style="color: var(--primary)"></i>
                    <h2 style="margin:0; font-size:1.1rem; font-weight: 700;">Pulso Diario</h2>
                </div>
                <button onclick="expandirPanel('p-pulso')" style="background:none; border:none; cursor:pointer;">
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>
            </div>
            <div class="panel-body-collapse">
                <div class="timeline-modern">
                    @foreach ($actividadPorDia as $dia)
                        <div class="timeline-item">
                            <div style="font-size: 0.9rem; font-weight: 700;">
                                {{ \Carbon\Carbon::parse($dia->fecha)->translatedFormat('d M, Y') }}</div>
                            <div style="font-size: 0.8rem; color: var(--primary); font-weight: 600;">
                                {{ $dia->total }} acciones</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
 
<script>
    function expandirPanel(id) {
        const panel = document.getElementById(id);
        panel.classList.toggle('collapsed');
        const icon = panel.querySelector('.chevron-icon');
        if (panel.classList.contains('collapsed')) {
            icon.style.transform = 'rotate(-90deg)';
        } else {
            icon.style.transform = 'rotate(0deg)';
        }
    }

    function verMas() {
        // Mostramos todos los logs al hacer clic
        const tableBody = document.querySelector('#p-actividad tbody');
        tableBody.innerHTML = `
            @foreach ($logs as $log)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: #1e293b;">{{ $log->titulo }}</div>
                        <span style="font-size: 0.7rem; font-weight: 800; color: {{ $log->accion == 'creado' ? 'var(--success)' : ($log->accion == 'editado' ? 'var(--primary)' : 'var(--danger)') }}">
                            ● {{ strtoupper($log->accion) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="user-avatar">{{ substr($log->user->name ?? 'S', 0, 1) }}</div>
                            <span style="font-weight: 500; font-size: 0.9rem;">{{ $log->user->name ?? 'Sistema' }}</span>
                        </div>
                    </td>
                    <td style="color: #64748b;">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        `;
        document.getElementById('verMasLogs').style.display = 'none';
    }
</script>

@endsection