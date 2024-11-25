<?php

use App\Http\Controllers\ReconocimientoController;
use Illuminate\Support\Facades\Route;


Route::get('reconocimientos', [ReconocimientoController::class, 'getIndex']);

Route::get('reconocimientos/show/{id}', [ReconocimientoController::class, 'getShow']) ->where('id', '[0-9]+');

Route::get('reconocimientos/create', [ReconocimientoController::class, 'getCreate']);

Route::get('reconocimientos/edit/{id}', [ReconocimientoController::class, 'getEdit']) ->where('id', '[0-9]+');
