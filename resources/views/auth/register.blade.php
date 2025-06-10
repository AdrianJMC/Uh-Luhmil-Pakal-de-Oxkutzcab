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
                    <div class="password-wrapper">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        <span class="toggle-password" id="togglePassword" title="Mostrar/Ocultar contraseña">
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
                            </svg>
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


                {{-- Confirmar contraseña --}}
                <div class="mb-4">
                    <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                    <div class="password-wrapper">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required>
                        <span class="toggle-password" id="toggleConfirmPassword" title="Mostrar/Ocultar contraseña">
                            <svg id="icon-eye-confirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z" />
                            </svg>
                            <svg id="icon-eye-off-confirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // campo principal
        const toggle1 = document.getElementById('togglePassword');
        const input1 = document.getElementById('password');
        const eye1 = document.getElementById('icon-eye');
        const eyeOff1 = document.getElementById('icon-eye-off');

        toggle1.addEventListener('click', () => {
            const isPassword = input1.type === 'password';
            input1.type = isPassword ? 'text' : 'password';
            eye1.style.display = isPassword ? 'none' : 'inline';
            eyeOff1.style.display = isPassword ? 'inline' : 'none';
        });

        // campo confirmar contraseña
        const toggle2 = document.getElementById('toggleConfirmPassword');
        const input2 = document.getElementById('password-confirm');
        const eye2 = document.getElementById('icon-eye-confirm');
        const eyeOff2 = document.getElementById('icon-eye-off-confirm');

        toggle2.addEventListener('click', () => {
            const isPassword = input2.type === 'password';
            input2.type = isPassword ? 'text' : 'password';
            eye2.style.display = isPassword ? 'none' : 'inline';
            eyeOff2.style.display = isPassword ? 'inline' : 'none';
        });
    });
</script>
@endpush