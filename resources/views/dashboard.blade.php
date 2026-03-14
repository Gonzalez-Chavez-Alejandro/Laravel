@extends('layouts.admin')

@section('content')
    <h2 class="text-3xl font-bold mb-6">Dashboard Administrativo</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-slate-800 rounded-md">
            <h3 class="text-xl font-semibold">Usuarios</h3>
            <p class="mt-2">Gestiona todos los usuarios registrados.</p>
        </div>

        <div class="p-4 bg-slate-800 rounded-md">
            <h3 class="text-xl font-semibold">Dudas</h3>
            <p class="mt-2">Crea, edita y elimina publicaciones.</p>
            <aside class="w-64 bg-slate-900 shadow-xl border-r border-slate-700 flex flex-col">
                <div class="p-6">
                    <h1 class="text-lg font-bold mb-6">{{ config('app.name') }} Admin</h1>

                   <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-md hover:bg-slate-800 hover:text-yellow-400">
                    Dashboard
                </a>

                <a href="{{ route('dudas.create') }}"
                   class="block px-4 py-2 rounded-md hover:bg-slate-800 hover:text-yellow-400">
                    Crear Duda
                </a>
            </nav>
                </div>
            </aside>

        </div>

        <div class="p-4 bg-slate-800 rounded-md">
            <h3 class="text-xl font-semibold">Categorías</h3>
            <p class="mt-2">Gestiona las categorías de tus posts.</p>
        </div>
    </div>
@endsection
