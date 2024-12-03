<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Estudiante;

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




Route::get('pruebaDB/{id?}', function ($votos = null) {
    $html = '';

    $count = Estudiante::where('votos', '>', 100)->count();
    $max = Estudiante::max('votos');
    $min = Estudiante::min('votos');
    $media = Estudiante::avg('votos');
    $total = Estudiante::sum('votos');

    $html = '<ul>';
    $html .= '<li>Estudiantes con más de 100 votos: ' . $count . '</li>';
    $html .= '<li>Máximo número de votos: ' . $max . '</li>';
    $html .= '<li>Mínimo número de votos: ' . $min . '</li>';
    $html .= '<li>Media de votos: ' . $media . '</li>';
    $html .= '<li>Total de votos: ' . $total . '</li>';

    $html . "</ul>\n<ul>";


    $estudiantes = Estudiante::where('votos', '>', $votos)->take(5)->get();

    foreach( $estudiantes as $estudiante ) {
        $html .= '<li>' . $estudiante->nombre . '</li>';
    }






    $count = Estudiante::where('votos', '>', 100)->count();
    $html .= 'Antes: ' . $count . '<br />';

    $id = $votos ? $votos : 1;

    $estudiante = Estudiante::findOrFail($id);
    $estudiante->nombre = 'Juan';
    $estudiante->apellidos = 'Martínez';
    $estudiante->direccion = 'Dirección de Juan';
    $estudiante->votos = 130;
    $estudiante->confirmado = true;
    $estudiante->ciclo = 'DAW';
    $estudiante->save();

    $count = Estudiante::where('votos', '>', 100)->count();
    $html .= 'Después: ' . $count . '<br />';



    return $html . '</ul>';

});





include __DIR__.'/actividades.php';
include __DIR__.'/curriculos.php';
include __DIR__.'/proyectos.php';
include __DIR__.'/reconocimientos.php';
include __DIR__.'/users.php';
