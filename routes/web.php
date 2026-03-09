<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DudaController;

Route::resource('dudas', DudaController::class);
/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página principal: muestra todos los posts con sus bloques
Route::get('/', function () {
    $posts = \App\Models\Post::with('blocks')->get();
    return view('welcome', compact('posts'));
})->name('home');

// Mostrar un post individual (opcional si quieres vista detallada)
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

/*
|--------------------------------------------------------------------------
| Dashboard protegido
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil del usuario
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Panel de administración
| Solo accesible por usuarios autenticados (puedes agregar middleware de rol)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {

        // Dashboard del admin
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.dashboard');

        // Crear post + bloques
        Route::get('/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('admin.posts.store');

        // Editar post
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');

        // Eliminar post
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (login, registro, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';