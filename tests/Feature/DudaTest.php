<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DudaTest extends TestCase
{
    use RefreshDatabase;

    protected function admin()
{
    $this->actingAs(
        User::factory()->create([
            'role' => 'admin'
        ])
    );
}

    /* CARGA LA PAGINA DE DUDAS */
    public function test_pagina_dudas_carga(): void
    {
        $this->admin();

        $response = $this->get('/admin/dudas');

        $response->assertStatus(200);
    }

    /* FORMULARIO CREATE */
    public function test_formulario_crear_duda(): void
    {
        $this->admin();

        $response = $this->get('/admin/dudas/create');

        $response->assertStatus(200);
    }

    /* GUARDA UNA DUDA */
    public function test_se_puede_guardar_duda(): void
    {
        $this->admin();

        $response = $this->post('/admin/dudas', [
            'titulo_categoria' => 'Problema de instalación',
            'descripcion' => ['Primer bloque'],
            'layout_bloque' => ['caso1']
        ]);

        $response->assertRedirect('/admin/dudas');

        $this->assertDatabaseHas('dudas', [
            'titulo_categoria' => 'Problema de instalación'
        ]);
    }

    /* TITULO REQUERIDO */
    public function test_no_se_puede_guardar_sin_titulo(): void
    {
        $this->admin();

        $response = $this->post('/admin/dudas', [
            'descripcion' => ['Texto'],
            'layout_bloque' => ['caso1']
        ]);

        $response->assertSessionHasErrors('titulo_categoria');
    }

    /* DESCRIPCION REQUERIDA */
    public function test_no_se_puede_guardar_sin_descripcion(): void
    {
        $this->admin();

        $response = $this->post('/admin/dudas', [
            'titulo_categoria' => 'Problema',
            'layout_bloque' => ['caso1']
        ]);

        $response->assertSessionHasErrors('descripcion');
    }

    /* LAYOUT INVALIDO */
    public function test_layout_invalido(): void
    {
        $this->admin();

        $response = $this->post('/admin/dudas', [
            'titulo_categoria' => 'Problema',
            'descripcion' => ['Texto'],
            'layout_bloque' => ['caso9']
        ]);

        $response->assertSessionHasErrors('layout_bloque.0');
    }

    /* VARIOS BLOQUES */
    public function test_guardar_varios_bloques(): void
    {
        $this->admin();

        $response = $this->post('/admin/dudas', [
            'titulo_categoria' => 'Problema múltiple',
            'descripcion' => [
                'Bloque 1',
                'Bloque 2'
            ],
            'layout_bloque' => [
                'caso1',
                'caso2'
            ]
        ]);

        $response->assertRedirect('/admin/dudas');

        $this->assertDatabaseHas('dudas', [
            'titulo_categoria' => 'Problema múltiple'
        ]);
    }

    /* GUARDAR CON IMAGEN */
    public function test_se_puede_guardar_duda_con_imagen(): void
    {
        $this->admin();

        Storage::fake('public');

        $imagen = UploadedFile::fake()->image('foto.jpg');

        $response = $this->post('/admin/dudas', [
            'titulo_categoria' => 'Problema con imagen',
            'descripcion' => ['Texto con imagen'],
            'layout_bloque' => ['caso1'],
            'imagen' => [$imagen]
        ]);

        $response->assertRedirect('/admin/dudas');

        $this->assertDatabaseHas('dudas', [
            'titulo_categoria' => 'Problema con imagen'
        ]);
    }
}