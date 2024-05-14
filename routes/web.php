<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\EntradaController::class, 'index'])->name('home');
//Route::get('/entries', [\App\Http\Controllers\EntradaController::class, 'index'])->name('entries');

Route::resource('/categorias', App\Http\Controllers\CategoriaController::class);
Route::resource('/entradas', App\Http\Controllers\EntradaController::class);
Route::resource('/entrada', App\Http\Controllers\EntradaController::class);
