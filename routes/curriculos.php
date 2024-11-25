<?php

use App\Http\Controllers\CurriculoController;
use Illuminate\Support\Facades\Route;

Route::get('curriculos', [CurriculoController::class, 'getIndex']);

Route::get('curriculos/show/{id}', [CurriculoController::class, 'getShow'])
->where('id', '[0-9]+');

Route::get('curriculos/create', [CurriculoController::class, 'getCreate']);

Route::get('curriculos/edit/{id}', [CurriculoController::class, 'getEdit'])
->where('id', '[0-9]+');
