<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Temas') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo-lobito-sin-fondo.png') }}" type="image/png">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contenedor_principal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dudas.css') }}">
    @stack('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>

.titulo-tranquilo {
    font-size: 2rem;          
    font-weight: 500;         
    color: #4B5563;           
    margin-bottom: 1.5rem;    
    letter-spacing: 0.05em;   
    border-bottom: 2px solid #E5E7EB; 
    padding-bottom: 0.3rem;   
}


.titulo-tranquilo::first-letter {
    text-transform: uppercase; 
    font-size: 2.3rem;         
    font-weight: 600;           
    color: #1F2937;             
}
</style>

<body class="font-sans antialiased bg-gray-900 min-h-screen">

    @include('layouts.navigation')
    <div>
        @include('layouts.dudas')
    </div>

<script>
const buscador = document.getElementById("buscadorDudas");
let tiempoEspera; // Variable para el temporizador

buscador.addEventListener("input", function() {
    let texto = this.value.toLowerCase();
    let temas = document.querySelectorAll(".tema-duda");
    let links = document.querySelectorAll(".sidebar-menu li");

    // 1. FILTRADO INMEDIATO (Esto no mueve la pantalla, solo oculta/muestra)
    let primerEncontrado = null;
    temas.forEach((tema, index) => {
        let contenido = tema.innerText.toLowerCase();
        if (contenido.includes(texto)) {
            tema.style.display = "block";
            if (links[index]) links[index].style.display = "block";
            if (!primerEncontrado) primerEncontrado = tema;
        } else {
            tema.style.display = "none";
            if (links[index]) links[index].style.display = "none";
        }
    });

    // 2. SCROLL INTELIGENTE (Solo ocurre cuando dejas de escribir)
    clearTimeout(tiempoEspera); // Limpia el cronómetro si el usuario sigue tecleando

    if (texto.length > 2 && primerEncontrado) {
        tiempoEspera = setTimeout(() => {
            primerEncontrado.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 600); // 600ms de espera (poco más de medio segundo)
    }
});
</script>


</body>

</html>
