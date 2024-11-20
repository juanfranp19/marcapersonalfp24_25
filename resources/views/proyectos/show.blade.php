@extends('layouts.master')

@section('content')


    <div class="row m-4">

        <div class="col-sm-4">

            <img src="/images/mp-logo.png" style="height:200px"/>

        </div>
        <div class="col-sm-8">

            <h3><strong>Nombre: </strong>{{ $proyecto['nombre'] }}</h3>
            <h4><strong>Dominio: </strong>
                <a href="http://github.com/2DAW-CarlosIII/{{ $proyecto['dominio'] }}">
                    http://github.com/2DAW-CarlosIII/{{ $proyecto['dominio'] }}
                </a>
            </h4>
            <h4><strong>Docente: </strong>{{ $proyecto['docente_id'] }}</h4>
            <p><strong>Metadatos: </strong>
                <ul>
                    @foreach ($proyecto['metadatos'] as $indice => $metadato)
                        <li>{{ $indice }}: {{ $metadato }}</li>
                    @endforeach
                </ul>
            </p>
            <p><strong>Estado: </strong>
                @if($proyecto['metadatos']['calificacion'] >= 5)
                    Proyecto aprobado
                @else
                    Proyecto suspenso
                @endif
            </p>

            @if($proyecto['metadatos']['calificacion'] >= 5)
                <a class="btn btn-danger" href="#">Suspender proyecto</a>
            @else
                <a class="btn btn-primary" href="#">Aprobar proyecto</a>
            @endif
            <a class="btn btn-warning" href="{{ action([App\Http\Controllers\ProyectosController::class, 'getEdit'], ['id' => $id]) }}">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Editar proyecto
            </a>
            <a class="btn btn-outline-info" href="{{ action([App\Http\Controllers\ProyectosController::class, 'getIndex']) }}">
                Volver al listado
            </a>


        </div>
    </div>

@endsection

