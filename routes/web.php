<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\EntradaController::class, 'index'])->name('home');
Route::get('/tasks', [\App\Http\Controllers\TareaController::class, 'index'])->name('tasks');
Route::get('/tarea/pdf', [\App\Http\Controllers\TareaController::class, 'pdf'])->name('tarea.pdf');


//Route::get('/entries', [\App\Http\Controllers\EntradaController::class, 'index'])->name('entries');

Route::resource('/entradas', App\Http\Controllers\EntradaController::class);
Route::resource('/entrada', App\Http\Controllers\EntradaController::class);
Route::resource('/tarea', App\Http\Controllers\TareaController::class);
