<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function() {
    return view('auth.login');
});

Route::get('logout', function() {
    return 'Logout usuario';
});

Route::get('proyectos', function() {
    return view('proyectos.index');
});

Route::get('proyectos/show/{id}', function($id) {
    return view('proyectos.show', array('id'=>$id));
})->where('id', '[0-9]+');

Route::get('proyectos/create', function() {
    return view('proyectos.create');
});

Route::get('proyectos/edit/{id}', function($id) {
    return view('proyectos.edit', array('id'=>$id));
})->where('id', '[0-9]+');

Route::get('perfil/{id?}', function($id = null) {
    return $id ? 'Visualizar el currículo de '. $id : 'Visualizar el currículo propio';
})->where('id', '[0-9]*');

Route::get('user/{nombre}', [UserController::class, 'showProfile']);
