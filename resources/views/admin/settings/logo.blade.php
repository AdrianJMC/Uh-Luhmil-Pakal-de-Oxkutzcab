{{-- resources/views/admin/settings/logo.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="logo-settings-container position-relative">
        <div class="logo-card">
            {{-- Encabezado verde --}}
            <div class="logo-card-header">
                <h2>
                    {{-- Flecha SVG dentro de un círculo --}}
                    <a href="{{ route('admin.pages.index') }}#pane-logo" class="back-arrow" title="Volver a Secciones Web">
                        <!-- SVG de flecha izquierda (Bootstrap Icons) -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                            class="bi bi-arrow-left back-arrow-icon" aria-hidden="true">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5
                 0 1 0-.708-.708l-4 4a.5.5
                 0 0 0 0 .708l4 4a.5.5
                 0 0 0 .708-.708L2.707
                 8.5H14.5A.5.5 0 0 0 15 8z" />
                        </svg>
                    </a>
                    Logo Global
                </h2>
            </div>

            {{-- Cuerpo de la tarjeta --}}
            <div class="logo-card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Sección: Logo Actual --}}
                <div class="current-logo-section">
                    <label class="current-logo-label">Logo Actual</label>
                    <div class="current-logo-box">
                        @if ($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Actual">
                        @else
                            <span class="no-logo-text">No hay logo subido</span>
                        @endif
                    </div>
                </div>

                {{-- Formulario de subida --}}
                <form action="{{ route('admin.settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group upload-section">
                        <label class="upload-label" for="logoInput">Subir Nuevo Logo</label>
                        <input type="file" name="logo" id="logoInput" accept="image/*" class="d-block mx-auto"
                            style="max-width: 250px;" required>
                        <small id="file-name-display" class="text-secondary d-block text-center mt-2"></small>
                        @error('logo')
                            <small class="text-danger d-block text-center mt-1">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn update-btn">
                            Actualizar Logo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputLogo = document.getElementById('logoInput');
            const nameDisplay = document.getElementById('file-name-display');

            inputLogo.addEventListener('change', function() {
                if (inputLogo.files && inputLogo.files.length > 0) {
                    nameDisplay.textContent = inputLogo.files[0].name;
                } else {
                    nameDisplay.textContent = '';
                }
            });
        });
    </script>
@endsection
