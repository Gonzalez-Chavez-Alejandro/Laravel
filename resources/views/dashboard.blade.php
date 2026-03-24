@extends('layouts.app_admin')
@section('title', 'Gestión')
@section('content')

    <div class="div_edit_contenido_principal">

        <div class="div_edit_card">
            <h3 class="div_edit_titulo">
                <i class="fas fa-users"></i> Usuarios
            </h3>
            <p class="div_edit_texto">
                Gestiona todos los usuarios registrados y sus permisos.
            </p>
            <a href="{{ route('admin.users.index') }}" class="div_edit_boton">Administrar Usuarios</a>
        </div>

        <div class="div_edit_card">
            <h3 class="div_edit_titulo">
                 <i class="fas fa-question"></i> Dudas </h3>
            <p class="div_edit_texto">
                Crea, edita y elimina publicaciones de forma sencilla.
            </p>
            <a href="{{ route('admin.dudas.index') }}" class="div_edit_boton">Administrar Duda</a>

        </div>

        <div class="div_edit_card">
            <h3 class="div_edit_titulo">
                <i class="fas fa-chart-bar"></i> Reportes</h3>
            <p class="div_edit_texto">
                Revisa estadísticas y reportes del sistema.
            </p>
            <a href="#" class="div_edit_boton">Administrar Reportes</a>
        </div>

    </div>

@endsection
