<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReconocimientoController;

Route::get('reconocimientos', [ReconocimientoController::class, 'getIndex']);

Route::get('reconocimientos/show/{id}', [ReconocimientoController::class, 'getShow']);

Route::get('reconocimientos/create', [ReconocimientoController::class, 'getCreate']);

Route::get('reconocimientos/edit/{id}', [ReconocimientoController::class, 'getEdit']);

