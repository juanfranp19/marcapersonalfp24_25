@extends('layouts.master')

@section('content')


    <div class="row m-4">

        <div class="col-sm-4">

            <img width="256" alt="Award icon" src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Award_icon.png">

        </div>
        <div class="col-sm-8">

            <h3><strong>Estudiante</strong>{{ $reconocimiento['estudiante_id'] }}</h3>
            <h4><strong>Documento: </strong>
                <a href="http://github.com/2DAW-CarlosIII/{{ $reconocimiento['documento'] }}">
                    http://github.com/2DAW-CarlosIII/{{ $reconocimiento['documento'] }}
                </a>
            </h4>
            <h4><strong>Actividad: </strong>{{ $reconocimiento['actividad_id'] }}</h4>
            <h4><strong>Docente validador: </strong>{{ $reconocimiento['docente_validador'] }}</h4>
            <h4><strong>Fecha: </strong>{{ $reconocimiento['fecha'] }}</h4>

            <div class="buttons">
                <a class="button alt" href="{{ action([App\Http\Controllers\ReconocimientoController::class, 'getEdit'], ['id' => $id]) }}">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    Editar reconocimiento
                </a>
                <a class="button alt" href="{{ action([App\Http\Controllers\ReconocimientoController::class, 'getIndex']) }}">
                    Volver al listado
                </a>
            </div>

        </div>
    </div>

@endsection
