<?php

use App\Http\Controllers\ReconocimientoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reconocimientos'], function() {

    Route::get('/', [ReconocimientoController::class, 'getIndex']);
    Route::get('/show/{id}', [ReconocimientoController::class, 'getShow']) ->where('id', '[0-9]+');
    Route::get('/create', [ReconocimientoController::class, 'getCreate']);
    Route::get('/edit/{id}', [ReconocimientoController::class, 'getEdit']) ->where('id', '[0-9]+');
});
