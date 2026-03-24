@extends('layouts.app_admin')

@section('title', 'Gestión de Dudas')

@section('header')

@endsection

@section('content')

    <div class="contenedor-dudas">
        <div class="header-dudas">
            <!-- Grupo Izquierdo: Título y Navegación -->
            <div class="contenedor-titulo">
                <a href="{{ route('dashboard') }}" class="btn-regresar" title="Volver al panel">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h1-gestion-dudas">Gestión de Dudas</h1>
            </div>

            <!-- Grupo Derecho: Herramientas -->
            <div class="acciones-header">
                <div class="search-container">
                    <span class="icono-busqueda">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="buscador" placeholder="Buscar por título..." value="{{ $buscar ?? '' }}"
                        class="input-buscador">
                </div>

                <a href="{{ route('admin.dudas.create') }}" class="btn-crear-duda">
                    <i class="fas fa-plus"></i> <span>Crear Duda</span>
                </a>
            </div>
        </div>


        <div class="card-tabla">
            <div class="tabla-responsive">
                <table class="tabla-dudas">
                    <thead>
                        <tr>
                            <th class="th-dudas-ID">ID</th>
                            <th class="th-dudas-Titulo">Título</th>
                            <th class="th-dudas-Descripcion">Descripción</th>
                            <th class="th-dudas-Imagenes">Imágenes</th>
                            <th class="th-dudas-Acciones">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dudas as $duda)
                            <tr class="fila-duda">

                                <td class="td-gestion-dudas-ID">{{ $duda->id }}</td>

                                <td class="titulo-dudas">
                                    {{ $duda->titulo_categoria }}
                                </td>

                                <td>
                                    @foreach ($duda->descripcion as $desc)
                                        <p class="texto-descripcion">
                                            {{ \Illuminate\Support\Str::limit($desc, 60) }}
                                        </p>
                                    @endforeach
                                </td>

                                <!-- IMÁGENES -->
                                <td>
                                    <div class="carousel-container">
                                        @php $imagenes = (array) ($duda->imagen ?? []); @endphp

                                        {{-- Mostrar flecha izquierda solo si hay más de 1 imagen --}}
                                        @if (count($imagenes) > 1)
                                            <button class="btn-nav" onclick="prevImg(this)">&#10094;</button>
                                        @endif

                                        <div class="contenedor-imagenes">
                                            @forelse ($imagenes as $index => $img)
                                                <img src="{{ $img }}"
                                                    class="img-mini {{ $index == 0 ? 'active' : '' }}">
                                            @empty
                                                <span class="texto-sin-img">No hay fotos</span>
                                            @endforelse
                                        </div>

                                        {{-- Mostrar flecha derecha solo si hay más de 1 imagen --}}
                                        @if (count($imagenes) > 1)
                                            <button class="btn-nav" onclick="nextImg(this)">&#10095;</button>
                                        @endif
                                    </div>
                                </td>



                                <!-- ACCIONES -->
                                <td class="td-gestion-dudas-ACCIONES">
                                    <div class="acciones-duda">
                                        <a href="{{ route('admin.dudas.edit', $duda->id) }}" class="btn-editar">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form id="form-delete-{{ $duda->id }}"
                                            action="{{ route('admin.dudas.destroy', $duda->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn-eliminar"
                                                onclick="confirmarEliminacion({{ $duda->id }})">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>

                                        </form>
                                        </form>
                                    </div>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="paginacion">
                {{-- Botón anterior --}}
                @if ($dudas->onFirstPage())
                    <span class="disabled">←</span>
                @else
                    <a href="{{ $dudas->previousPageUrl() }}">←</a>
                @endif

                {{-- Números --}}
                @for ($i = 1; $i <= $dudas->lastPage(); $i++)
                    @if ($i == $dudas->currentPage())
                        <span class="active">{{ $i }}</span>
                    @else
                        <a href="{{ $dudas->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Botón siguiente --}}
                @if ($dudas->hasMorePages())
                    <a href="{{ $dudas->nextPageUrl() }}">→</a>
                @else
                    <span class="disabled">→</span>
                @endif
            </div>
        </div>
        @if (session('deleted'))
            <script>
                Swal.fire(
                    'Eliminado',
                    '{{ session('deleted') }}',
                    'success'
                );
            </script>
        @endif
        @if (session('created'))
            <script>
                Swal.fire({
                    title: 'Guardado',
                    text: '{{ session('created') }}',
                    icon: 'success',
                    confirmButtonColor: '#2563eb'
                });
            </script>
        @endif
    </div>
    <script>
        function prevImg(btn) {
            const contenedor = btn.nextElementSibling;
            cambiarImagen(contenedor, -1);
        }

        function nextImg(btn) {
            const contenedor = btn.previousElementSibling;
            cambiarImagen(contenedor, 1);
        }

        function cambiarImagen(contenedor, step) {
            const imagenes = contenedor.querySelectorAll('.img-mini');
            if (imagenes.length <= 1) return;

            let indexActivo = Array.from(imagenes).findIndex(img => img.classList.contains('active'));
            imagenes[indexActivo].classList.remove('active');

            let nuevoIndex = (indexActivo + step + imagenes.length) % imagenes.length;
            imagenes[nuevoIndex].classList.add('active');
        }
    </script>
    <script>
        const buscador = document.getElementById('buscador');

        let timeout;

        buscador.addEventListener('input', function() {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const valor = this.value;

                const url = new URL(window.location.href);

                if (valor) {
                    url.searchParams.set('buscar', valor);
                } else {
                    url.searchParams.delete('buscar');
                }

                window.location.href = url.toString();
            }, 500);
        });
    </script>
    <script>
        function confirmarEliminacion(id) {
            Swal.fire({
                title: '¿Eliminar duda?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            });
        }
    </script>
@endsection
