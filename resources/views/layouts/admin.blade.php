<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen bg-gray-900 text-gray-100">

    {{-- Sidebar --}}
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
                    Crear Post
                </a>

                <a href="{{ route('admin.posts.edit', 1) }}"
                   class="block px-4 py-2 rounded-md hover:bg-slate-800 hover:text-yellow-400">
                    Editar Post
                </a>

                

            </nav>
        </div>
    </aside>

    {{-- Contenido principal --}}
    <main class="flex-1 p-6 overflow-y-auto">
        {{-- Aquí se inyecta el contenido de cada página --}}
        @yield('content')
    </main>

</body>
</html>