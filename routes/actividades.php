<?php

use App\Http\Controllers\ActividadController;

Route::get('actividades', [ActividadController::class, 'getIndex']);

Route::get('actividades/show/{id}', [ActividadController::class, 'getShow'])->where('id', '[0-9]+');

Route::get('actividades/create', [ActividadController::class, 'getCreate']);

Route::get('actividades/edit/{id}', [ActividadController::class, 'getEdit'])->where('id', '[0-9]+');
