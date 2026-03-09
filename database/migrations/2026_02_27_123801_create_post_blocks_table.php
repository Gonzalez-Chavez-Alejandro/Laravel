<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_blocks', function (Blueprint $table) {
            $table->id();

            // Relación con el post
            $table->foreignId('post_id')
                ->constrained('posts')  // asegura que se conecte a posts
                ->onDelete('cascade');

            $table->enum('type', ['text', 'image']); // tipo de bloque
            $table->longText('content')->nullable(); // contenido principal, para imágenes puede ser URL
            $table->enum('position', ['top', 'left', 'right'])->nullable(); // posición relativa si aplica
            $table->longText('text')->nullable(); // texto opcional si el bloque es imagen + texto
            $table->integer('order')->default(0); // orden de aparición en el post

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_blocks');
    }
};