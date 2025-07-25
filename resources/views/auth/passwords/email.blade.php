@extends('layouts.auth')

@section('content')
<div class="auth-card auth-card-agrupaciones">
    {{-- Panel derecho: formulario --}}
    <div class="card-right">
        <h2>Recuperar contraseña</h2>

        @if (session('status'))
            <div class="alert alert-success" role="alert" style="max-width: 340px; margin: 0 auto 1rem;">
                {{ __('Hemos enviado un enlace a tu correo para restablecer tu contraseña.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert" style="display: block; color: red; font-size: 0.9rem; text-align: left; margin-top: 0.25rem;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-auth">Enviar enlace</button>
        </form>

        <a href="{{ route('login') }}" class="auth-forgot">Volver al inicio de sesión</a>
    </div>
</div>
@endsection
