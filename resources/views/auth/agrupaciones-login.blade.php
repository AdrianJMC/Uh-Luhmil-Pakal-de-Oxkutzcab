@extends('layouts.auth')

@section('title', 'Ingreso Agrupación')

@section('content')
    <div class="auth-card auth-card-agrupaciones">
        {{-- Panel izquierdo con logo y mensaje --}}
        <div class="card-left">
            <a href="{{ route('inicio') }}" aria-label="Volver al inicio">
                @include('partials.home.logo')
            </a>
            <h2>Acceso Agrupaciones</h2>
            <p>Ingresa con el correo de representante autorizado.</p>
        </div>

        {{-- Panel derecho con el formulario --}}
        <div class="card-right" style="position: relative;">

            {{-- Botón de regreso al selector --}}
            <a href="{{ route('seleccion.login') }}" class="btn-back-selector" aria-label="Volver al selector">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H6.707l1.147 1.146a.5.5
                        0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2a.5.5 0 1 1 .708.708L6.707 7.5H11.5z" />
                </svg>
            </a>

            {{-- Logo en móviles --}}
            <div class="mobile-logo">
                <a href="{{ route('inicio') }}" aria-label="Volver al inicio">
                    @include('partials.home.logo')
                </a>
            </div>

            <h3 class="mb-4">Ingreso para Agrupaciones</h3>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('agrupaciones.login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email">Correo del representante</label>
                    <input type="email" name="email" id="email" class="form-control" required autofocus>
                </div>

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

                <button type="submit" class="btn-auth">Ingresar</button>
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
