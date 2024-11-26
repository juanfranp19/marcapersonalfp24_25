<?php

use App\Http\Controllers\ActividadController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'actividades'], function() {

    Route::get('/', [ActividadController::class, 'getIndex']);
    Route::get('/show/{id}', [ActividadController::class, 'getShow'])->where('id', '[0-9]+');
    Route::get('/create', [ActividadController::class, 'getCreate']);
    Route::get('/edit/{id}', [ActividadController::class, 'getEdit'])->where('id', '[0-9]+');
});
