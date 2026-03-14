<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/contenedor_principal.css') }}">
    @endpush



    <div class="contenedor">

        <div class="faq-form">

            <h2 class="faq-form__title">Crear nuevo Tema</h2>

            <form action="{{ route('dudas.store') }}" method="POST" enctype="multipart/form-data" class="faq-form__form">
                @csrf

                <!-- TITULO -->
                <div class="form-group">
                    <label class="form-group__label">Título de la categoría</label>
                    <input class="form-group__input" type="text" name="titulo_categoria"
                        placeholder="Ej. Problemas de instalación" required>
                </div>

                <!-- BLOQUES -->
                <div id="blocks-container" class="faq-form__blocks">

                    <div class="faq-block">

                        <button type="button" class="faq-block__remove">Eliminar</button>

                        <div class="form-group">
                            <label class="form-group__label">Descripción</label>
                            <textarea class="form-group__textarea" name="descripcion[0]" rows="4" placeholder="Escribe la descripción..."
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-group__label">Imagen (opcional)</label>
                            <input class="form-group__file imagen-input" type="file" name="imagen[0]">
                            <img class="faq-block__preview hidden">
                        </div>

                        <div class="form-group">
                            <label class="form-group__label">Tipo de diseño</label>
                            <select class="form-group__select" name="layout_bloque[0]">
                                <option value="caso1">Imagen izquierda</option>
                                <option value="caso2">Imagen derecha</option>
                                <option value="caso3">Imagen arriba</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="faq-form__actions">

                    <button type="button" id="add-block" class="btn btn--success">
                        + Agregar bloque
                    </button>

                    <button type="submit" class="btn btn--primary">
                        Guardar Duda
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        // Inicializamos el contador basado en cuántos bloques hay (empezamos con 1)
        let bloqueCount = 1;

        document.getElementById('add-block').addEventListener('click', () => {

            const container = document.getElementById('blocks-container');

            const bloque = document.createElement('div');
            bloque.className = "faq-block";

            bloque.innerHTML = `
        <button type="button" class="faq-block__remove">Eliminar</button>

        <div class="form-group">
            <label class="form-group__label">Descripción</label>
            <textarea class="form-group__textarea"
                name="descripcion[${bloqueCount}]"
                rows="4"
                placeholder="Escribe la descripción..."
                required></textarea>
        </div>

        <div class="form-group">
            <label class="form-group__label">Imagen</label>
            <input class="imagen-input" type="file" name="imagen[${bloqueCount}]">
            <img class="faq-block__preview hidden">
        </div>

        <div class="form-group">
            <label class="form-group__label">Tipo de diseño</label>
            <select class="form-group__select" name="layout_bloque[${bloqueCount}]">
                <option value="caso1">Imagen izquierda</option>
                <option value="caso2">Imagen derecha</option>
                <option value="caso3">Imagen arriba</option>
            </select>
        </div>
    `;

            container.appendChild(bloque);

            bloqueCount++;

        });

        /* ELIMINAR BLOQUE */
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-bloque')) {
                const bloques = document.querySelectorAll('.bloque');
                // Evitamos borrar todos los bloques, dejamos al menos uno
                if (bloques.length > 1) {
                    e.target.closest('.bloque').remove();
                } else {
                    alert("Debes mantener al menos un bloque informativo.");
                }
            }
        });

        /* PREVIEW IMAGEN (Mejorado para detectar el cambio correctamente) */
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('imagen-input')) {
                const file = e.target.files[0];
                const preview = e.target.nextElementSibling; // El elemento <img> justo después del input

                if (file && preview) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('hidden');
                } else {
                    preview.classList.add('hidden');
                }
            }
        });
    </script>
</x-app-layout>
