@extends('layouts.master')

@section('content')

<div class="row" style="margin-top:40px">
   <div class="offset-md-3 col-md-6">
      <div class="card">
         <div class="card-header text-center">
            Modificar Reconocimiento
         </div>
         <div class="card-body" style="padding:30px">

            <form action="{{ action([App\Http\Controllers\ReconocimientoController::class, 'getEdit'], ['id' => $id]) }}" method="POST">
                @method('PUT')
	            @csrf

	            <div class="form-group">
	               <label for="estudiante_id">Estudiante id</label>
	               <input type="text" name="estudiante_id" id="estudiante_id" class="form-control">
	            </div>

	            <div class="form-group">
	               <label for="docente_validator">Actividad id</label>
	               <input type="number" name="docente_validator" id="docente_validator">
	            </div>

	            <div class="form-group">
	               <label for="documento">Documento</label><br />
                    https://github.com/2DAW-CarlosIII/
	               <input type="text" name="documento" id="documento" class="form-control">
	            </div>

	            <div class="form-group">
	               <label for="fecha">Fecha</label>
	               <textarea name="fecha" id="fecha" class="form-control" rows="3"></textarea>
                   <br />
	            </div>

                <div class="form-group">
                    <label for="docente_validator">Docente validator</label>
                    <input type="number" name="docente_validator" id="docente_validator">
                 </div>

	            <div class="form-group text-center">
	               <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
	                   Modificar Reconocimiento
	               </button>
	            </div>

            </form>

         </div>
      </div>
   </div>
</div>

@endsection
