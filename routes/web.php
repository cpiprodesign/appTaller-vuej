<?php

use Illuminate\Support\Facades\Route;

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
    return view('contenido/contenido');
});
//clientes
Route::get('cliente', [App\Http\Controllers\ClienteController::class, 'index'])->name('cliente');
Route::post('/cliente/registrar', [App\Http\Controllers\ClienteController::class,'store']);
Route::put('/cliente/actualizar',  [App\Http\Controllers\ClienteController::class,'update']);
Route::put('/cliente/desactivar',  [App\Http\Controllers\ClienteController::class,'desactivar']);
Route::put('/cliente/activar',  [App\Http\Controllers\ClienteController::class,'activar']);
Route::get('/cliente/selectCliente',  [App\Http\Controllers\ClienteController::class,'selectCliente']);
Route::get('/cliente/listarPdf',  [App\Http\Controllers\ClienteController::class,'listarPdf'])->name('clientes_pdf');

//tecnicos

Route::get('tecnico', [App\Http\Controllers\TecnicoController::class, 'index'])->name('tecnico');
Route::post('/tecnico/registrar', [App\Http\Controllers\TecnicoController::class,'store']);
Route::put('/tecnico/actualizar',  [App\Http\Controllers\TecnicoController::class,'update']);
Route::put('/tecnico/desactivar',  [App\Http\Controllers\TecnicoController::class,'desactivar']);
Route::put('/tecnico/activar',  [App\Http\Controllers\TecnicoController::class,'activar']);
Route::get('/tecnico/selectTecnico',  [App\Http\Controllers\TecnicoController::class,'selectTecnico']);
Route::get('/tecnico/listarPdf',  [App\Http\Controllers\TecnicoController::class,'listarPdf'])->name('tecnicos_pdf');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
