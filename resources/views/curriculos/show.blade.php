@extends('layouts.master')

@section('content')


    <div class="row m-4">

        <div class="col-sm-4">

            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Curriculum-vitae-warning-icon.svg/256px-Curriculum-vitae-warning-icon.svg.png" style="height:200px"/>

        </div>
        <div class="col-sm-8">

            <h3><strong>Curriculo ID: </strong>{{ $curriculos['user_id'] }}</h3>
            <h4><strong>Video curriculo: </strong>
                <a href="http://github.com/2DAW-CarlosIII/{{ $curriculos['video_curriculum'] }}">
                    http://github.com/2DAW-CarlosIII/{{ $curriculos['video_curriculum'] }}
                </a>
            </h4>
            <p><strong>Texto del Curriculo </strong> {{ $curriculos['texto_curriculum'] }}
            </p>

            <a class="btn btn-warning" href="{{ action([App\Http\Controllers\CurriculoController::class, 'getEdit'], ['id' => $id]) }}">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Editar curriculo
            </a>
            <a class="btn btn-outline-info" href="{{ action([App\Http\Controllers\CurriculoController::class, 'getIndex']) }}">
                Volver al listado
            </a>


        </div>
    </div>

@endsection


