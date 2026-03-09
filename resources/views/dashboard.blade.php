@extends('layouts.admin')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Dashboard Administrativo</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-slate-800 rounded-md">
            <h3 class="text-xl font-semibold">Usuarios</h3>
            <p class="mt-2">Gestiona todos los usuarios registrados.</p>
        </div>

        <div class="p-4 bg-slate-800 rounded-md">
            <h3 class="text-xl font-semibold">Posts</h3>
            <p class="mt-2">Crea, edita y elimina publicaciones.</p>
        </div>

        <div class="p-4 bg-slate-800 rounded-md">
            <h3 class="text-xl font-semibold">Categorías</h3>
            <p class="mt-2">Gestiona las categorías de tus posts.</p>
        </div>
    </div>
@endsection