{{-- resources/views/posts/show.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800;900&display=swap');
        .font-pro { font-family: 'Figtree', sans-serif; }

        .content-wrapper { 
            max-width: 900px; 
            margin: 0 auto; 
        }

        .fancy-card {
            background: white;
            border-radius: 24px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03); 
            overflow: hidden;
            margin-bottom: 2.5rem;
        }

        .img-box {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8fafc;
            min-height: 250px;
            overflow: hidden;
        }
        
        .img-box img {
            width: 100%;
            height: 100%;
            max-height: 450px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .img-box img:hover {
            transform: scale(1.02);
        }
        
        .block-top {
            display: flex;
            flex-direction: column;
        }
        
        .block-text {
            font-size: 1.125rem;
            line-height: 1.75;
            color: #475569;
        }
        
        .text-container {
            padding: 2.5rem;
        }
        
        .text-block-simple {
            padding: 2.5rem;
            font-size: 1.125rem;
            line-height: 1.75;
            color: #334155;
        }
        
        @media (max-width: 768px) {
            .text-container, .text-block-simple {
                padding: 1.5rem;
            }
            
            .md\:flex-row, .md\:flex-row-reverse {
                flex-direction: column !important;
            }
            
            .md\:w-1\/2 {
                width: 100% !important;
            }
        }
    </style>

    <div class="bg-slate-50 min-h-screen py-16 px-6 font-pro">
        <article class="content-wrapper">
            
            {{-- Header del Post --}}
            <header class="mb-16 text-center">
                <h1 class="text-5xl font-black text-slate-900 leading-tight mb-6">{{ $post->title }}</h1>
                @if($post->description)
                    <p class="text-xl text-slate-500 italic border-l-4 border-blue-500 pl-6 max-w-2xl mx-auto text-left">
                        {{ $post->description }}
                    </p>
                @endif
            </header>

            {{-- Verificar si hay bloques --}}
            @if($post->blocks->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    Este post no tiene bloques de contenido.
                </div>
            @else
                {{-- Bloques Dinámicos --}}
                <div class="space-y-8">
                    @foreach($post->blocks as $block)
                        
                        {{-- BLOQUE DE TEXTO SIMPLE --}}
                        @if($block->type === 'text' && $block->content)
                            <div class="fancy-card">
                                <div class="text-block-simple">
                                    {{ $block->content }}
                                </div>
                            </div>

                        {{-- BLOQUE DE IMAGEN CON TEXTO --}}
                        @elseif($block->type === 'image')
                            <div class="fancy-card 
                                @if($block->position === 'top')
                                    block-top
                                @elseif($block->position === 'left')
                                    md:flex md:flex-row
                                @elseif($block->position === 'right')
                                    md:flex md:flex-row-reverse
                                @endif
                            ">
                                
                                {{-- POSICIÓN TOP (Imagen arriba, texto abajo) --}}
                                @if($block->position === 'top')
                                    {{-- Imagen --}}
                                    <div class="img-box w-full" style="min-height: 300px;">
                                        <img src="{{ asset('storage/' . $block->content) }}" 
                                             alt="Imagen del post"
                                             onerror="this.src='https://via.placeholder.com/800x400?text=Imagen+no+encontrada'">
                                    </div>
                                    {{-- Texto --}}
                                    @if($block->text)
                                        <div class="text-container text-center">
                                            <p class="block-text">
                                                {{ $block->text }}
                                            </p>
                                        </div>
                                    @endif
                                
                                {{-- POSICIÓN LEFT (Imagen izquierda, texto derecho) --}}
                                @elseif($block->position === 'left')
                                    {{-- Imagen --}}
                                    <div class="img-box w-full md:w-1/2">
                                        <img src="{{ asset('storage/' . $block->content) }}" 
                                             alt="Imagen del post"
                                             onerror="this.src='https://via.placeholder.com/600x400?text=Imagen+no+encontrada'">
                                    </div>
                                    {{-- Texto --}}
                                    @if($block->text)
                                        <div class="w-full md:w-1/2 flex items-center">
                                            <div class="text-container w-full text-left">
                                                <p class="block-text">
                                                    {{ $block->text }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                
                                {{-- POSICIÓN RIGHT (Imagen derecha, texto izquierdo) --}}
                                @elseif($block->position === 'right')
                                    {{-- Texto (izquierda) --}}
                                    @if($block->text)
                                        <div class="w-full md:w-1/2 flex items-center order-1 md:order-1">
                                            <div class="text-container w-full text-left md:text-right">
                                                <p class="block-text">
                                                    {{ $block->text }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    {{-- Imagen (derecha) --}}
                                    <div class="img-box w-full md:w-1/2 order-2 md:order-2">
                                        <img src="{{ asset('storage/' . $block->content) }}" 
                                             alt="Imagen del post"
                                             onerror="this.src='https://via.placeholder.com/600x400?text=Imagen+no+encontrada'">
                                    </div>
                                @endif

                            </div>
                        @endif

                    @endforeach
                </div>
            @endif

            {{-- Debug info (solo para desarrollo) --}}
            @if(app()->environment('local'))
                <div class="mt-8 p-4 bg-gray-100 rounded-lg text-xs">
                    <details open>
                        <summary class="cursor-pointer text-blue-600 font-semibold">Ver datos del post (debug)</summary>
                        <pre class="mt-2 overflow-auto">{{ json_encode($post->load('blocks'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                    </details>
                </div>
            @endif

            {{-- Botón para volver --}}
            <div class="mt-8 text-center">
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Volver
                </a>
            </div>
        </article>
    </div>
</x-app-layout>