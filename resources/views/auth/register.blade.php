@extends('layouts.auth')
@section('title', 'Crear Cuenta')

@section('content')
    <div class="card auth-card">

        {{-- Panel izquierdo --}}
        <div class="card-left">
            <a href="{{ route('inicio') }}" aria-label="Volver al inicio">
                @include('partials.home.logo')
            </a>
            <h2>Uh Luhmil Pakal</h2>
            <p>Regístrate para acceder a ofertas exclusivas y gestionar tus pedidos.</p>
        </div>

        {{-- Panel derecho --}}
        <div class="card-right">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <h2>Crear Cuenta</h2>
                </div>

                {{-- Nombre --}}
                <div class="mb-4">
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Apellido -->
                <div class="mb-4">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror"
                        name="apellido" value="{{ old('apellido') }}" required autofocus>
                    @error('apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-4">
                    <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-auth">
                        Registrarse
                    </button>
                </div>

                {{-- Ya tienes cuenta? --}}
                <a href="{{ route('login') }}" class="link-register">
                    ¿Ya tienes cuenta? <strong>Inicia Sesión</strong>
                </a>

            </form>
        </div>
    </div>
@endsection
