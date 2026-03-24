<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DudaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DudaVistaController;
/*

|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $posts = \App\Models\Post::with('blocks')->get();
    return view('welcome', compact('posts'));
})->name('home');

Route::get('/dudas', [DudaVistaController::class, 'index'])->name('dudas.index');
 Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
/*

|
| 2. RUTAS SOLO PARA ADMINISTRADORES (Crear, Editar, Borrar)
|--------------------------------------------------------------------------

| IMPORTANTE: Estas van primero para que "admin/dudas/create" no se confunda
| con "admin/dudas/{duda}"
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {

    Route::resource('users', AdminUserController::class);
    Route::resource('dudas', DudaController::class);
});


/*

|--------------------------------------------------------------------------
| 3. RUTAS PARA TODOS LOS LOGUEADOS (Usuario y Admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ver Dudas (Lista y Detalle)
    // Van al final porque tienen parámetros variables como {duda}
    
    Route::get('/admin/dudas/{duda}', [DudaController::class, 'show'])->name('dudas.show');
    
});

require __DIR__.'/auth.php';
