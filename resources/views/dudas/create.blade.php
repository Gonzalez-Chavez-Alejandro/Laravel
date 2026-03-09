<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/contenedor_principal.css') }}">
    @endpush
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/') }}">
    @endpush

    <div class="contenedor">
        <div class="max-w-2xl mx-auto p-8">
            <form action="{{ route('dudas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Título -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Título de la categoría
                    </label>
                    <input type="text" name="titulo_categoria"
                        class="w-full border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg p-3 transition"
                        placeholder="Ej. Problemas de instalación" required>
                </div>

                <!-- Bloques -->
                <div id="bloques-container" class="space-y-6">

                    <div class="bloque bg-gray-50 border border-gray-200 rounded-xl p-6 space-y-4 relative">

                        <button type="button"
                            class="remove-bloque absolute top-3 right-3 text-sm bg-red-100 text-red-600 px-3 py-1 rounded-lg hover:bg-red-200 transition">
                            Eliminar
                        </button>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Descripción
                            </label>
                            <textarea name="descripcion[]" rows="4"
                                class="w-full border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg p-3 transition"
                                placeholder="Escribe la descripción..." required></textarea>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Imagen (opcional)
                            </label>
                            <input type="file" name="imagen[]"
                                class="w-full border border-gray-300 rounded-lg p-2 bg-white">
                        </div>

                        <!-- Layout -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de diseño
                            </label>
                            <select name="layout_bloque[]"
                                class="w-full border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-lg p-3 bg-white transition">
                                <option value="caso1">Imagen a la izquierda</option>
                                <option value="caso2">Imagen a la derecha</option>
                                <option value="caso3">Imagen arriba</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between items-center pt-4 border-t">

                    <button type="button" id="add-bloque"
                        class="bg-green-600 hover:bg-green-700 text-black px-5 py-2 rounded-xl font-semibold shadow-md transition">
                        + Agregar bloque
                    </button>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-black px-6 py-2 rounded-xl font-semibold shadow-md transition">
                        Guardar Duda
                    </button>

                </div>
            </form>
        </div>
    </div>

    <!-- JS para agregar/eliminar bloques dinámicos -->
    <script>
        // Agregar bloque
        document.getElementById('add-bloque').addEventListener('click', function() {
            const container = document.getElementById('bloques-container');
            const bloque = document.createElement('div');
            bloque.classList.add('bloque', 'flex', 'flex-col', 'gap-2', 'border', 'p-2', 'rounded');

            bloque.innerHTML = `
                <textarea name="descripcion[]" placeholder="Descripción" class="border p-2 rounded" required></textarea>
                <input type="file" name="imagen[]" class="border p-2 rounded">
                <select name="layout_bloque[]" class="border p-2 rounded bg-white">
                    <option value="caso1">Imagen a la Izquierda (Caso 1)</option>
                    <option value="caso2">Imagen a la Derecha (Caso 2)</option>
                    <option value="caso3">Imagen Arriba (Caso 3)</option>
                </select>
                <button type="button" class="remove-bloque bg-red-500 text-black p-2 rounded">Eliminar</button>
            `;
            container.appendChild(bloque);
        });

        // Eliminar bloque
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-bloque')) {
                e.target.closest('.bloque').remove();
            }
        });
    </script>
</x-app-layout>
