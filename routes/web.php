<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use GuzzleHttp\Psr7\Request;

Route::get('/', [HomeController::class, 'getHome']);

Route::get('login', function() {
    return view('auth.login');
});

Route::get('logout', function() {
    return 'Logout usuario';
});

Route::get('perfil/{id?}', function($id = null) {
    return $id ? 'Visualizar el currículo de '. $id : 'Visualizar el currículo propio';
})->where('id', '[0-9]*');

Route::get('formulario', function() {
    return view('formulario');
});

Route::post('formulario', function() {
    return back()->withInput();
});

include __DIR__.'/actividades.php';
include __DIR__.'/curriculos.php';
include __DIR__.'/proyectos.php';
include __DIR__.'/reconocimientos.php';
include __DIR__.'/users.php';
