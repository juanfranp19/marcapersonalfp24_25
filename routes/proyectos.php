<?php

use App\Http\Controllers\ProyectosController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'proyectos'], function(){

    Route::get('/', [ProyectosController::class, 'getIndex']);
    Route::post('/', [ProyectosController::class, 'store']);

    Route::get('/show/{id}', [ProyectosController::class, 'getShow'])
        ->where('id', '[0-9]+');

    Route::get('/create', [ProyectosController::class, 'getCreate']);

    Route::get('/edit/{id}', [ProyectosController::class, 'getEdit'])
        ->where('id', '[0-9]+');
    Route::put('/{id}', [ProyectosController::class, 'putEdit']);
});
