@extends('layouts.app_admin')
@section('title', 'Editar Duda')

@section('content')
    <div class="div-edit-contenedor">

        <div class="contenedor-dudas">
            <div class="contenedor-titulo">
                <a href="{{ route('admin.dudas.index') }}" class="btn-regresar" title="Volver al panel">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="h1-gestion-dudas">Editar Duda</h1>
            </div>
            <h2 class="div-edit-titulo"></h2>

            <form action="{{ route('admin.dudas.update', $duda->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- TITULO -->
                <div class="div-edit-grupo">
                    <label class="form-group__label">Título</label>
                    <input class="form-group__input" type="text" name="titulo_categoria"
                        value="{{ $duda->titulo_categoria }}" required>
                </div>

                <!-- BLOQUES -->
                <div id="blocks-container">

                    @foreach ($duda->descripcion as $index => $desc)
                        <div class="div-edit-bloque">

                            <button type="button" class="div-edit-btn-eliminar faq-block__remove">✕</button>

                            <!-- DESCRIPCION -->
                            <div class="div-edit-grupo">
                                <label class="form-group__label">Descripción</label>
                                <textarea class="form-group__textarea" name="descripcion[{{ $index }}]" required>{{ $desc }}</textarea>
                            </div>

                            <!-- IMAGEN -->
                            <div class="div-edit-grupo">
                                <label class="div-edit-label">Imagen</label>

                                <div class="div-edit-dropzone">

                                    <p class="div-edit-drop-text">
                                        Arrastra tu imagen o haz click
                                    </p>

                                    <input type="file" name="imagen[{{ $index }}]" class="imagen-input" hidden>

                                    @if (!empty($duda->imagen[$index]))
                                        <img src="{{ $duda->imagen[$index] }}" class="div-edit-preview">
                                    @else
                                        <img class="div-edit-preview hidden">
                                    @endif

                                </div>
                            </div>

                            <!-- LAYOUT -->
                            <div class="div-edit-grupo">
                                <label class="div-edit-label">Diseño</label>
                                <select class="div-edit-select" name="layout_bloque[{{ $index }}]">
                                    <option value="caso1" {{ $duda->layout[$index] == 'caso1' ? 'selected' : '' }}>
                                        Imagen izquierda
                                    </option>
                                    <option value="caso2" {{ $duda->layout[$index] == 'caso2' ? 'selected' : '' }}>
                                        Imagen derecha
                                    </option>
                                    <option value="caso3" {{ $duda->layout[$index] == 'caso3' ? 'selected' : '' }}>
                                        Imagen arriba
                                    </option>
                                </select>
                            </div>

                        </div>
                    @endforeach

                </div>

                <!-- BOTONES -->
                <div class="div-edit-acciones">

                    <button type="button" id="add-block" class="div-edit-btn-success">
                        <i class="fas fa-plus"></i><span>Agregar</span>
                    </button>

                    <button type="submit" class="div-edit-btn-primary">
                        <i class="fas fa-save"></i><span>Guardar</span>
                    </button>

                </div>

            </form>

        </div>

    </div>
    
    <script>
        let bloqueCount = {{ count($duda->descripcion) }};

        // AGREGAR BLOQUE
        document.getElementById('add-block').addEventListener('click', () => {

            const container = document.getElementById('blocks-container');

            const bloque = document.createElement('div');
            bloque.className = "div-edit-bloque";

            bloque.innerHTML = `
        <button type="button" class="div-edit-btn-eliminar faq-block__remove">✕</button>

        <div class="div-edit-grupo">
            <label class="div-edit-label">Descripción</label>
            <textarea class="div-edit-textarea" name="descripcion[${bloqueCount}]" required></textarea>
        </div>

        <div class="div-edit-grupo">
            <label class="div-edit-label">Imagen</label>

            <div class="div-edit-dropzone">
                <p class="div-edit-drop-text">
                    Arrastra tu imagen o haz click
                </p>

                <input type="file" name="imagen[${bloqueCount}]" class="imagen-input" hidden>

                <img class="div-edit-preview hidden">
            </div>
        </div>

        <div class="div-edit-grupo">
            <label class="div-edit-label">Diseño</label>
            <select class="div-edit-select" name="layout_bloque[${bloqueCount}]">
                <option value="caso1">Imagen izquierda</option>
                <option value="caso2">Imagen derecha</option>
                <option value="caso3">Imagen arriba</option>
            </select>
        </div>
    `;

            container.appendChild(bloque);
            bloqueCount++;
        });

        // ELIMINAR BLOQUE
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('faq-block__remove')) {

                const bloques = document.querySelectorAll('.div-edit-bloque');

                if (bloques.length > 1) {
                    e.target.closest('.div-edit-bloque').remove();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Mínimo requerido',
                        text: 'Debes mantener al menos un bloque informativo',
                        confirmButtonColor: '#111827'
                    });
                }
            }
        });

        // CLICK → abrir selector
        document.addEventListener('click', (e) => {
            const dropzone = e.target.closest('.div-edit-dropzone');
            if (dropzone) {
                dropzone.querySelector('input').click();
            }
        });

        // PREVIEW
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('imagen-input')) {

                const file = e.target.files[0];
                const dropzone = e.target.closest('.div-edit-dropzone');
                const preview = dropzone.querySelector('.div-edit-preview');

                if (file && preview) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('hidden');
                }
            }
        });

        // DRAG OVER
        document.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        // DRAG ENTER
        document.addEventListener('dragenter', (e) => {
            const dz = e.target.closest('.div-edit-dropzone');
            if (dz) dz.classList.add('active');
        });

        // DRAG LEAVE
        document.addEventListener('dragleave', (e) => {
            const dz = e.target.closest('.div-edit-dropzone');
            if (dz) dz.classList.remove('active');
        });

        // DROP
        document.addEventListener('drop', (e) => {
            e.preventDefault();

            const dz = e.target.closest('.div-edit-dropzone');

            if (dz) {
                dz.classList.remove('active');

                const input = dz.querySelector('input');
                input.files = e.dataTransfer.files;

                input.dispatchEvent(new Event('change'));
            }
        });
    </script>

@endsection
