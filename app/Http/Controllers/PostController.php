<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostBlock;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Mostrar el formulario para crear un post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Guardar un nuevo post con bloques.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'blocks' => 'nullable|array',
            'blocks.*.type' => 'required|in:text,image',
            'blocks.*.text' => 'nullable|string',
            'blocks.*.position' => 'nullable|in:top,left,right',
            'blocks.*.content' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('blocks')) {
            foreach ($request->blocks as $index => $block) {
                $type = $block['type'] ?? null;
                $position = $block['position'] ?? 'top';
                $text = $block['text'] ?? null;
                $content = null;

                if ($type === 'text') {
                    $content = $text;
                    $text = null;
                }

                if ($type === 'image' && isset($block['content'])) {
                    $content = $block['content']->store('posts', 'public');
                }

                PostBlock::create([
                    'post_id' => $post->id,
                    'type' => $type,
                    'content' => $content,
                    'text' => $text,
                    'position' => $position,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('posts.show', $post)->with('success', 'Publicación creada correctamente');
    }

    /**
     * Mostrar un post con sus bloques.
     */
    public function show(Post $post)
    {
        // Cargar los bloques ordenados
        $post->load(['blocks' => function($query) {
            $query->orderBy('order');
        }]);

        return view('posts.show', compact('post'));
    }
}