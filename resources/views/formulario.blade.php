@extends('layouts.master')

@section('content')

<form action="formulario" method="POST">
    @csrf
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    <button type="submit">Enviar</button>
</form>

@stop
