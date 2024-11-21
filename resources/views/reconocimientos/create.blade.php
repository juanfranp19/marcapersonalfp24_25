@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Añadir reconocimiento
         </div>
         <div class="card-body" style="padding:30px">

            <form action="{{ url('/reconocimientos/create') }}" method="POST">

	            @csrf

	            <div class="form-group">
	               <label for="estudiante_id">Estudiante</label>
	               <input type="number" name="estudiante_id" id="estudiante_id" class="form-control">
	            </div>

	            <div class="form-group">
	               <label for="actividad_id">Actividad</label>
	               <input type="number" name="actividad_id" id="actividad_id">
	            </div>

	            <div class="form-group">
	               <label for="documento">URL del documento</label>
	               <input type="url" name="documento" id="documento" class="form-control">
	            </div>

                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control">
                </div>

                <div class="form-group">
                    <label for="docente_validador">Docente Validador</label>
                    <input type="number" name="docente_validador" id="docente_validador" class="form-control">
                 </div>

	            <div class="form-group text-center">
	               <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
	                   Añadir reconocimiento
	               </button>
	            </div>

            </form>

         </div>
      </div>
   </div>
</div>

@endsection
