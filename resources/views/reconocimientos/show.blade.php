@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="image featured" title="Sakatsp, CC BY-SA 4.0 &lt;https://creativecommons.org/licenses/by-sa/4.0&gt;, via Wikimedia Commons"><img width="256" alt="Award icon" src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Award_icon.png"></a>
            </div>

            <div class="col-md-6">
                <h2>Datos del Reconocimiento</h2><br>
                <ul>
                    <li><strong>Estudiante ID:</strong> {{ $reconocimiento['estudiante_id'] }}</li>
                    <li><strong>Actividad ID:</strong> {{ $reconocimiento['actividad_id'] }}</li>
                    <li><strong>Documento:</strong> {{ $reconocimiento['documento'] }}</li>
                    <li><strong>Fecha:</strong> {{ $reconocimiento['fecha'] }}</li>
                    <li><strong>Docente Validador:</strong> {{ $reconocimiento['docente_validador'] }}</li>
                </ul>

                <div class="buttons">
                    <!-- Botón para editar -->
                    <a href="{{ action([App\Http\Controllers\ReconocimientoController::class, 'getEdit'], ['id' => $id] ) }}" class="button alt">Editar reconocimiento</a></li>
                    <!-- Botón para volver al listado -->
                    <a href="{{ action([App\Http\Controllers\ReconocimientoController::class, 'getIndex']) }}" class="button alt">Volver al listado</a></li>
                </div>
            </div>
        </div>
    </div>


@endsection

