@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Modificar proyecto
         </div>
         <div class="card-body" style="padding:30px">

            <form action="{{ action([App\Http\Controllers\ProyectosController::class, 'getEdit'], ['id' => $id]) }}" method="POST">
                @method('PUT')
	            @csrf

	            <div class="form-group">
	               <label for="nombre">Nombre</label>
	               <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $proyecto['nombre'] }}">
	            </div>

	            <div class="form-group">
	               <label for="docente_id">Docente</label>
	               <input type="number" name="docente_id" id="docente_id"  value="{{ $proyecto['docente_id'] }}">
	            </div>

	            <div class="form-group">
	               <label for="dominio">Dominio</label><br />
                    https://github.com/2DAW-CarlosIII/
	               <input type="text" name="dominio" id="dominio" class="form-control" value="{{ $proyecto['dominio'] }}">
	            </div>

	            <div class="form-group">
	               <label for="metadatos">Metadatos</label>
	               <textarea name="metadatos" id="metadatos" class="form-control" rows="3">
@foreach ($proyecto['metadatos'] as $clave => $metadato)
{{ $clave }}: {{ $metadato }}
@endforeach
                    </textarea>
                   <br /><small>Cada metadato irá separado del siguiente por una línea <br />
                   y la clave irá separada por : del valor</small>
	            </div>

	            <div class="form-group text-center">
	               <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
	                   Modificar proyecto
	               </button>
	            </div>

            </form>

         </div>
      </div>
   </div>
</div>

@endsection
