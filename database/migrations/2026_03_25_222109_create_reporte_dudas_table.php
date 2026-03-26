<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reporte_dudas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('duda_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->string('titulo')->nullable();

            $table->string('estado')->default('pendiente');
            $table->string('accion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reporte_dudas');
    }
};
