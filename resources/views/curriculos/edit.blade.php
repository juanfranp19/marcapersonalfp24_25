@extends('layouts.master')


@section('content')


<div class="row" style="margin-top:40px">
    <div class="offset-md-3 col-md-6">
       <div class="card">
          <div class="card-header text-center">
             Modificar Currículum
          </div>
          <div class="card-body" style="padding:30px">

             <form action="{{ action([App\Http\Controllers\CurriculoController::class, 'getEdit'], ['id' => $id]) }}" method="POST">
                @method('PUT')
                 @csrf

                 <div class="form-group">
                    <label for="estudiante">Estudiante</label>
                    <input type="number" name="user_id" id="user_id"  value="{{ $curriculos['user_id'] }}">
                 </div>
                 <div class="form-group">
                    <label for="video_currículum">URL Videocurrículo</label>
                    <input type="url" name="video_currículum" id="video_currículum" class="form-control"  value="{{ $curriculos['video_curriculum'] }}>
                 </div>

                    <div class="form-group">
                    <label for="texto_currículum">Texto del currículo</label>
                    <textarea name="texto_currículum" id="texto_currículum" class="form-control" rows="5">
{{ $curriculos['texto_curriculum'] }}
                    </textarea>
                 <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" style="padding:8px 100px;margin-top:25px;">
                        Modificar Currículum
                    </button>
                 </div>
             </form>
          </div>
       </div>
    </div>
 </div>
@endsection
