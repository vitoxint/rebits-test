<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('usuarios', UsuarioController::class)->names([
    'index' => 'usuarios.index',
    'create' => 'usuarios.create',
    'store' => 'usuarios.store',
    'show' => 'usuarios.show',
    'edit' => 'usuarios.edit',
    'update' => 'usuarios.update',
    'destroy' => 'usuarios.destroy'
]);

Route::resource('vehiculos', VehiculoController::class)->names([
    'index' => 'vehiculos.index',
    'create' => 'vehiculos.create',
    'store' => 'vehiculos.store',
    'show' => 'vehiculos.show',
    'edit' => 'vehiculos.edit',
    'update' => 'vehiculos.update',
    'destroy' => 'vehiculos.destroy'
    
]);

Route::get('/massiveupload', function () {
    return Inertia::render('Vehiculo/Upload');
})->middleware(['auth', 'verified'])->name('massiveupload');

Route::post('vahiculos/upload' , [VehiculoController::class , 'massiveUpload'])->middleware(['auth', 'verified'])->name('vehiculos.upload');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
