@extends('layouts.error')

@section('title', '403 - Acceso Denegado')

@section('content')
<div class="error-container">
    <h1 class="error-code">403</h1>
    <h2 class="error-title">Acceso Denegado</h2>
    <p class="error-message">
        No tienes permisos para acceder a esta sección del sistema.
    </p>
    <a href="{{ route('inicio') }}" class="btn btn-primary btn-back">Volver al inicio</a>
</div>
@endsection
