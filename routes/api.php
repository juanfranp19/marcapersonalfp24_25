<?php

use App\Http\Controllers\API\ActividadController;
use App\Http\Controllers\API\CicloController;
use App\Http\Controllers\API\CompetenciaController;
use App\Http\Controllers\API\CurriculoController;
use App\Http\Controllers\API\EmpresaController;
use App\Http\Controllers\API\FamiliaProfesionalController;
use App\Http\Controllers\API\IdiomaController;
use App\Http\Controllers\API\ParticipanteProyectoController;
use App\Http\Controllers\API\ProyectosCiclosController;
use App\Http\Controllers\API\ProyectoController;
use App\Http\Controllers\API\ReconocimientoController;
use App\Http\Controllers\API\TokenController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UsersCiclosController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Psr\Http\Message\ServerRequestInterface;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config\Config;

Route::prefix('v1')->group(function () {
    Route::get('{tabla}/count', function ($tabla) {
        return response()->json([
            'count' => DB::table($tabla)->count()
        ], 200);
    });
    Route::apiResource('ciclos', CicloController::class);
    Route::apiResource('actividades', ActividadController::class)->parameters(['actividades' => 'actividad']);
    Route::apiResource('familias_profesionales', FamiliaProfesionalController::class)->parameters([
        'familias_profesionales' => 'familiaProfesional'
    ]);
    Route::apiResource('curriculos', CurriculoController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('proyectos', ProyectoController::class);
    Route::apiResource('reconocimientos', ReconocimientoController::class);
    Route::apiResource('participantes_proyectos', ParticipanteProyectoController::class);
    Route::apiResource('users_ciclos', UsersCiclosController::class);
    Route::apiResource('competencias', CompetenciaController::class);
    Route::apiResource('idiomas', IdiomaController::class);
    Route::get('proyectos/{proyectoId}/ciclos', [ProyectosCiclosController::class, 'indexProyectosCiclos']);
    Route::get('ciclos/{cicloId}/proyectos', [ProyectosCiclosController::class, 'indexCiclosProyectos']);
    Route::post('proyectos/{proyectoId}/ciclos', [ProyectosCiclosController::class, 'storeProyectoCiclo']);
    Route::apiResource('empresas', EmpresaController::class);
    Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
        return $request->user();
    });

    // Líneas de autenticación
    Route::post('tokens', [TokenController::class, 'store']);
    Route::delete('tokens', [TokenController::class, 'destroy'])->middleware('auth:sanctum');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');
});


Route::any('/{any}', function (ServerRequestInterface $request) {
    $config = new Config([
        'address' => env('DB_HOST', '127.0.0.1'),
        'database' => env('DB_DATABASE', 'forge'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'basePath' => '/api',
    ]);
    $api = new Api($config);
    $response = $api->handle($request);

    try {
        $records = json_decode($response->getBody()->getContents())->records;
        $response = response()->json($records, 200, $headers = ['X-Total-Count' => count($records)]);
    } catch (\Throwable $th) {
    }
    return $response;
})->where('any', '.*');
