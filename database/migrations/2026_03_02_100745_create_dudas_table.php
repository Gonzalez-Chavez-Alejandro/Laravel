<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dudas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_categoria');
            $table->json('descripcion'); 
            $table->json('imagen')->nullable(); 
            $table->string('layout')->default('caso1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dudas');
    }
};
