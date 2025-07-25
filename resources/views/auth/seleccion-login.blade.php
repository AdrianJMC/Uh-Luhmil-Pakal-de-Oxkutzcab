@extends('layouts.auth')

@section('title', 'Selector de acceso')

@section('content')
    <div class="selector-container">
        {{-- Encabezado verde (solo el logo dinámico con enlace) --}}
        <div class="selector-header">
            <div class="logo-wrapper">
                <a href="{{ route('inicio') }}" aria-label="Volver al inicio">
                    @include('partials.home.logo')
                </a>
            </div>
        </div>

        {{-- Cuerpo blanco --}}
        <div class="selector-body">
            <h2 class="selector-title">
                <span>Bienvenido</span><br>
                <span>a</span><br>
                <strong>Uh Lumil Pakal</strong>
            </h2>
            <p class="selector-subtitle">Selecciona el tipo de acceso para continuar con tu sesión</p>

            <h4 class="selector-question">¿Cómo deseas ingresar?</h4>

            <div class="selector-buttons-horizontal">
                <a href="{{ route('login') }}" class="btn-selector btn-cliente">
                    <span class="btn-text">Usuario</span>
                </a>

                <div class="selector-separator"><span>o</span></div>

                <a href="{{ route('agrupaciones.login') }}" class="btn-selector btn-agrupacion">
                    <span class="btn-text">Agrupación</span>
                </a>
            </div>
        </div>
    </div>
@endsection
