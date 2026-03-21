<div class="contenedor">

    <style>
        /* El contenedor relativo ahora maneja el centrado del icono */
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        #buscadorDudas {
            padding-left: 3.5rem !important;
            /* Espacio para la lupa */
            height: 50px;
            /* Altura cómoda para el buscador */
            border: 1px solid #e5e7eb;
            /* Gris claro casi invisible */
            transition: all 0.3s ease;
        }

        .lupa-wrapper {
            position: absolute;
            left: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 10;
        }

        #buscadorDudas:focus {
            border-color: #6366f1 !important;
            /* El azul de tu menú */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            /* Un pequeño resplandor azul */
        }

        .lupa-icon {
            width: 20px;
            height: 20px;
            color: #9ca3af;
            /* Gris suave */
        }

        .search input {
            transition: all 0.2s ease;
        }

        .search input:focus {
            transform: scale(1.01);
        }
    </style>

    <div class="search px-4 pt-3">
        <div class="search-container">
            <!-- El wrapper asegura que la lupa no se corte ni se mueva -->
            <div class="lupa-wrapper">
                <svg class="lupa-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>

            <input type="text" id="buscadorDudas" placeholder="Buscar temas..."
                class="w-full pr-4 rounded-lg border border-gray-300 bg-white text-gray-700
            focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
        </div>
    </div>



    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Menú lateral -->
        <aside
            class="hidden lg:block sidebar-menu w-64 bg-slate-900 text-slate-100 min-h-screen shadow-xl border-r border-slate-700">
            <div class="p-6">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-6">
                    Todos los temas
                </h3>
                <ul class="space-y-1">
                    @foreach ($dudas as $duda)
                        <li>
                            <a href="#duda-{{ $duda->id }}"
                                class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-all duration-200 hover:bg-slate-800 hover:text-yellow-400">
                                <!-- Pequeño indicador visual opcional -->
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-slate-600 mr-3 group-hover:bg-yellow-400 transition-colors"></span>

                                {{ $duda->titulo_categoria }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        <style>
            #casos {
                white-space: pre-line;
            }

            .highlight {
                background-color: yellow;
                color: black;
                padding: 2px;
                border-radius: 3px;
            }

            /* --- SOLUCIÓN PARA MÓVIL --- */
            @media (max-width: 768px) {
                .contenedor-caso {
                    flex-direction: column !important;
                    /* Fuerza orden vertical */
                    align-items: center !important;
                    /* Centra la imagen */
                }

                .contenedor-caso-reverse {
                    flex-direction: column-reverse !important;
                    /* Sube la imagen si estaba al final */
                    align-items: center !important;
                }

                .contenedor-caso img,
                .contenedor-caso-reverse img {
                    margin-bottom: 1rem;
                    /* Espacio entre imagen y texto */
                }
            }
        </style>
        <!-- Contenido principal -->
        <div class="flex-1 bg-gray-900 p-6">
            @foreach ($dudas as $duda)
                <div id="duda-{{ $duda->id }}" class="mb-10 tema-duda">
                    <h2 class="titulo-tranquilo text-2xl font-bold mb-4 titulo-duda text-white">
                        {{ $duda->titulo_categoria }}
                    </h2>

                    @foreach ($duda->descripcion as $i => $desc)
                        @php
                            $img = $duda->imagen[$i] ?? null;
                            $layout = $duda->layout[$i] ?? 'caso1';
                        @endphp

                        @if ($img)
                            @if ($layout == 'caso1')
                                {{-- Imagen izquierda --}}
                                <div class="flex gap-5 items-start mb-4 contenedor-caso">
                                    {{-- CORRECCIÓN: Se quitó asset('storage/' . $img) --}}
                                    <img src="{{ $img }}" width="200" class="rounded h-auto">
                                    <div
                                        class="flex-1 border border-gray-700 p-4 text-gray-300 italic whitespace-pre-line">
                                        {{ $desc }}
                                    </div>
                                </div>
                            @elseif($layout == 'caso2')
                                {{-- Texto izquierda --}}
                                <div class="flex gap-5 items-start mb-4 contenedor-caso-reverse">
                                    <div
                                        class="flex-1 border border-gray-700 p-4 text-gray-300 italic whitespace-pre-line">
                                        {{ $desc }}
                                    </div>
                                    {{-- CORRECCIÓN: Se quitó asset('storage/' . $img) --}}
                                    <img src="{{ $img }}" width="200" class="rounded h-auto">
                                </div>
                            @elseif($layout == 'caso3')
                                {{-- Imagen arriba --}}
                                <div class="mb-4">
                                    {{-- CORRECCIÓN: Se quitó asset('storage/' . $img) --}}
                                    <img src="{{ $img }}" width="100%" class="max-h-72 object-cover rounded">
                                    <div
                                        class="mt-2 border border-gray-700 p-4 w-full text-gray-300 italic text-center whitespace-pre-line">
                                        {{ $desc }}
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- Bloque sin imagen --}}
                            <div class="border border-gray-700 p-4 mb-4 text-gray-200 italic">
                                {{ $desc }}
                            </div>
                        @endif
                    @endforeach
                </div>
                <hr class="my-6 border-gray-700">
            @endforeach
        </div>
    </div>
</div>
