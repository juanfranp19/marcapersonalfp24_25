<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users', 'middleware' => 'auth'], function() {

    Route::get('/', [UserController::class, 'getIndex']);
    Route::get('/show/{id}', [UserController::class, 'getShow'])->where('id', '[0-9]*');
    Route::get('/create', [UserController::class, 'getCreate']);
    Route::get('/edit/{id}', [UserController::class, 'getEdit'])->where('id', '[0-9]*');
});
