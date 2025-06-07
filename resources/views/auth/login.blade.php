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
                    <div class="password-wrapper">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        <span id="togglePassword" class="toggle-password" title="Mostrar/Ocultar contraseña">
                            {{-- Ícono visible --}}
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
                            </svg>
                            {{-- Ícono oculto --}}
                            <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16" style="display: none;">
                                <path d="M13.359 11.238C14.27 10.242 15 8.97 15 8s-.73-2.242-1.641-3.238c-.92-.998-2.15-1.762-3.36-2.133a7.154
                                     7.154 0 0 0-2-.295 7.154 7.154 0 0 0-2 .295c-1.21.37-2.44 1.135-3.36 2.133C.73 5.758 0 7.03
                                     0 8c0 .97.73 2.242 1.641 3.238.92.998 2.15 1.762 3.36 2.133.644.197 1.32.295 2
                                     .295s1.356-.098 2-.295c1.21-.37 2.44-1.135 3.359-2.133zM4.146
                                     4.854a.5.5 0 1 1 .708-.708L12
                                     11.293a.5.5 0 0 1-.708.707L4.146 4.854z" />
                            </svg>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            const iconEye = document.getElementById('icon-eye');
            const iconEyeOff = document.getElementById('icon-eye-off');

            toggle.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                // alternar visibilidad de los íconos
                iconEye.style.display = isPassword ? 'none' : 'inline';
                iconEyeOff.style.display = isPassword ? 'inline' : 'none';
            });
        });
    </script>
@endpush
