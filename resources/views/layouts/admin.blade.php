<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Admin') }} - Admin</title>

    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen bg-gray-900 text-gray-100">

 

    {{-- Contenido principal --}}
    <main class="flex-1 p-6 overflow-y-auto">
        <h1 >{{ config('app.name') }} Admin</h1>
        {{-- Aquí se inyecta el contenido de cada página --}}
        @yield('content')
    </main>

</body>
</html>