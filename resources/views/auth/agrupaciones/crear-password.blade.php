@extends('layouts.auth')

@section('content')
<div class="auth-card auth-card-agrupaciones">
    {{-- Panel derecho: formulario --}}
    <div class="card-right">
        <h2>Crear contraseña</h2>

        <form method="POST" action="{{ route('agrupaciones.password.store') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            {{-- Password --}}
            <div class="mb-4">
                <label for="password">Nueva contraseña</label>
                <div class="password-wrapper">
                    <input id="password" type="password" name="password" class="form-control" required>
                    <span class="toggle-password" data-target="password">
                        <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                        </svg>
                        <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
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

            {{-- Confirm Password --}}
            <div class="mb-4">
                <label for="password_confirmation">Confirmar contraseña</label>
                <div class="password-wrapper">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                    <span class="toggle-password" data-target="password_confirmation">
                        <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                            <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                        </svg>
                        <svg class="icon-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
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

            <button type="submit" class="btn-auth">Establecer contraseña</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const inputId = toggle.getAttribute('data-target');
                const input = document.getElementById(inputId);
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                // íconos
                const eye = toggle.querySelector('.icon-eye');
                const eyeOff = toggle.querySelector('.icon-eye-off');
                eye.style.display = isPassword ? 'none' : 'inline';
                eyeOff.style.display = isPassword ? 'inline' : 'none';
            });
        });
    });
</script>
@endpush
