<div id="div-principal" class="h-64 border-b-2 border-b-gray-500">

    <!-- Contenedor de Texto y Botones -->
    <div class="flex flex-col gap-4">
        <h2 class="">Aprendiendo Laravel</h2>
        
        <div class="flex gap-2">
            <button type="button" class="btn-temas">
                <a href="{{ route('dudas.index') }}" class="btn-temas" style="all: unset; cursor: pointer;">
    Temas
</a></button>
            <button type="button" class="btn-contacto"><a href="{{ route('dudas.index') }}" class="btn-temas" style="all: unset; cursor: pointer;">
    contacto
</a></button>
        </div>
    </div>

    <div>
        <img src="{{ asset('img/lenguajes-perrito.png') }}" class="img-principal-wlcm" alt="Logo">
    </div>

</div>
