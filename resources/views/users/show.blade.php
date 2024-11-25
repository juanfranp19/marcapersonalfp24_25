@extends('layouts.master')

@section('content')


    <div class="row m-4">

        <div class="col-sm-4">

            <a href="#" class="image featured" title="Nice and Serious, CC0, via Wikimedia Commons"><img width="256" alt="User (89041) - The Noun Project" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/User_%2889041%29_-_The_Noun_Project.svg/256px-User_%2889041%29_-_The_Noun_Project.svg.png"></a>

        </div>
        <div class="col-sm-8">

            <h4><strong>Email: </strong>{{ $usuarios['email'] }}</h4>
            <h4><strong>Nombre: </strong>{{ $usuarios['first_name'] }}</h4>
            <h4><strong>Apellidos: </strong>{{ $usuarios['last_name'] }}</h4>
            <h4><strong>Linkedin: </strong>{{ $usuarios['linkedin'] }}</h4>

            <a class="btn btn-warning" href="{{ action([App\Http\Controllers\UserController::class, 'getEdit'], ['id' => $id]) }}">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                Editar usuarios
            </a>
            <a class="btn btn-outline-info" href="{{ action([App\Http\Controllers\UserController::class, 'getIndex']) }}">
                Volver al listado
            </a>


        </div>
    </div>

@endsection

