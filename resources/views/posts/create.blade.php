<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Crear Nuevo Post</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Título --}}
            <div class="mb-4">
                <label class="block font-semibold">Título</label>
                <input type="text" name="title" class="border rounded w-full p-2" value="{{ old('title') }}">
                @error('title')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label class="block font-semibold">Descripción</label>
                <textarea name="description" class="border rounded w-full p-2">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bloques dinámicos --}}
            <div id="blocks-container" class="mb-4"></div>

            <button type="button" id="add-block-btn" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">
                Agregar Bloque
            </button>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar Post</button>
        </form>
    </div>

    {{-- JS para bloques dinámicos --}}
    <script>
        let blockCount = 0;

        function addBlock() {
            blockCount++;
            const container = document.getElementById('blocks-container');
            const html = `
            <div class="block border p-4 mb-2 relative">
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-1 right-1 text-red-600">X</button>

                <select name="blocks[${blockCount}][type]" onchange="toggleContent(this, ${blockCount})" class="mb-2 border rounded p-1">
                    <option value="text">Texto</option>
                    <option value="image">Imagen</option>
                </select>

                <div id="text-container-${blockCount}">
                    <textarea name="blocks[${blockCount}][text]" placeholder="Texto del bloque" class="border rounded w-full p-2 mb-2"></textarea>
                </div>

                <div id="image-container-${blockCount}" class="hidden">
                    <input type="file" name="blocks[${blockCount}][content]" class="mb-2">
                    <input type="text" name="blocks[${blockCount}][text]" placeholder="Texto opcional de la imagen" class="border rounded w-full p-2">
                </div>

                <select name="blocks[${blockCount}][position]" class="border rounded p-1">
                    <option value="">--Posición--</option>
                    <option value="top">Arriba</option>
                    <option value="left">Izquierda</option>
                    <option value="right">Derecha</option>
                </select>

                <input type="number" name="blocks[${blockCount}][order]" value="${blockCount}" class="border rounded p-1 mt-2 w-20">
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
        }

        // Agregar un bloque inicial al cargar la página
        addBlock();

        // Botón para agregar más bloques
        document.getElementById('add-block-btn').addEventListener('click', addBlock);

        function toggleContent(select, id) {
            const textDiv = document.getElementById('text-container-' + id);
            const imageDiv = document.getElementById('image-container-' + id);
            if(select.value === 'text'){
                textDiv.classList.remove('hidden');
                imageDiv.classList.add('hidden');
            } else {
                textDiv.classList.add('hidden');
                imageDiv.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>