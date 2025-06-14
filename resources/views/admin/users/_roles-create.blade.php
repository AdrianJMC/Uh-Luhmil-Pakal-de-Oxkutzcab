@extends('layouts.admin')

@section('content')
<div class="container-fluid" style="max-width: 100%; padding: 0;">
    <div class="perfil-form-card perfil-form-full">
        <div class="perfil-form-card-header">
            <h2>Crear nuevo perfil</h2>
        </div>

        <div class="perfil-form-card-body">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="row gx-3 gy-2">
                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <label for="name" class="perfil-form-label">Nombre del perfil</label>
                        <input type="text" name="name" id="name"
                            class="perfil-form-input @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-md-6">
                        <label for="description" class="perfil-form-label">Descripción</label>
                        <textarea name="description" id="description" rows="2"
                            class="perfil-form-input @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Permisos --}}
                <h6 class="mt-4">Permisos del perfil</h6>
                <hr>
                <div class="row">
                    @foreach ($allPermissions as $permiso)
                        <div class="col-md-4 mb-2">
                            <label class="d-flex justify-content-between align-items-center">
                                <span>{{ ucwords(str_replace('_', ' ', $permiso->name)) }}</span>
                                <label class="switch">
                                    <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}">
                                    <span class="slider yellow"></span>
                                </label>
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-end mt-4">
                    <button class="btn btn-warning">Guardar perfil</button>
                    <a href="{{ route('admin.users.index', ['tab' => 'perfiles']) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
