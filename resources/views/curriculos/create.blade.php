@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir Currículum
         </div>
         <div class="card-body" style="padding:30px">

            <form action="{{ url('/curriculos/create') }}" method="POST">

	            @csrf

	            <div class="form-group">
	               <label for="nombre">Estudiante</label>
	               <input type="number" name="user_id" id="user_id" class="form-control">
	            </div>

	            <div class="form-group">
	               <label for="docente_id">URL Videocurrículo</label>
	               <input type="url" name="video_currículum" id="video_currículum">
	            </div>

	            <div class="form-group">
	               <label for="metadatos">Texto del currículo</label>
	               <textarea name="texto_curriculum" id="texto_curriculum" class="form-control" rows="3"></textarea>
                   <br /><small>Cada metadato irá separado del siguiente por una línea <br />
                   y la clave irá separada por : del valor</small>
	            </div>

	            <div class="form-group text-center">
	               <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
                    Añadir Currículum
	               </button>
	            </div>

            </form>

         </div>
      </div>
   </div>
</div>

@endsection

