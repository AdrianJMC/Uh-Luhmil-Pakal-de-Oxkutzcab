@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="slide-form-card">
            <div class="slide-form-card-header">
                <h2>Nuevo Slide</h2>
            </div>

            <div class="slide-form-card-body">
                <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row gx-3 gy-2">
                        {{-- Título --}}
                        <div class="col-md-6">
                            <label for="titulo" class="slide-form-label">Título</label>
                            <input type="text" name="titulo" id="titulo"
                                class="slide-form-input @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}"
                                required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Orden --}}
                        <div class="col-md-6">
                            <label for="orden" class="slide-form-label">Orden</label>
                            <input type="number" name="orden" id="orden"
                                class="slide-form-input @error('orden') is-invalid @enderror" value="{{ old('orden', 0) }}"
                                required>
                            @error('orden')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="col-12">
                            <label for="descripcion" class="slide-form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="2"
                                class="slide-form-input @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Imagen --}}
                        <div class="col-12">
                            <label for="imagen" class="slide-form-label">
                                Imagen de fondo <small class="text-muted">(obligatoria)</small>
                            </label>
                            <input type="file" name="imagen" id="imagen"
                                class="slide-form-file @error('imagen') is-invalid @enderror" required accept="image/*">
                            @error('imagen')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success me-2">Crear Slide</button>
                        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
