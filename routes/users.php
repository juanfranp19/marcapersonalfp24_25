<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'getIndex']);
Route::get('users/show/{id}', [UserController::class, 'getShow'])->where('id', '[0-9]*');
Route::get('users/create', [UserController::class, 'getCreate']);
Route::get('users/edit/{id}', [UserController::class, 'getEdit'])->where('id', '[0-9]*');
