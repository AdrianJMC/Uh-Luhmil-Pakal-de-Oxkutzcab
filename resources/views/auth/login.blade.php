@extends('layouts.auth')
@section('title', 'Iniciar Sesión')

@section('content')
    <div class="card auth-card">


        {{-- Panel izquierdo --}}
        <div class="card-left">
            <a href="{{ route('inicio') }}" aria-label="Volver al inicio">
                @include('partials.home.logo')
            </a>
            <h2>Uh Luhmil Pakal</h2>
            <p>¡Únete y descubre los mejores productos frescos directamente hasta tu puerta!</p>
        </div>

        {{-- Panel derecho --}}
        <div class="card-right">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <h2>Iniciar Sesión</h2>
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Recuérdame</label>
                </div>

                {{-- Submit --}}
                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-auth">
                        Entrar
                    </button>
                </div>

                {{-- Forgot Password --}}
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-forgot">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                {{-- Register Link --}}
                <a href="{{ route('register') }}" class="link-register">
                    ¿No tienes cuenta? Regístrate aquí
                </a>

            </form>

        </div>
    </div>
@endsection
