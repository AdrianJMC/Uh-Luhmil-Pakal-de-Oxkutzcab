@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <div class="slide-form-card">
      <div class="slide-form-card-header">
        <h2>Editar Slide</h2>
      </div>

      <div class="slide-form-card-body">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row gx-3 gy-2">
            {{-- Título --}}
            <div class="col-md-6">
              <label for="titulo" class="slide-form-label">Título</label>
              <input type="text" id="titulo" name="titulo"
                     class="slide-form-input @error('titulo') is-invalid @enderror"
                     value="{{ old('titulo', $slide->titulo) }}" required>
              @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Orden --}}
            <div class="col-md-6">
              <label for="orden" class="slide-form-label">Orden</label>
              <input type="number" id="orden" name="orden"
                     class="slide-form-input @error('orden') is-invalid @enderror"
                     value="{{ old('orden', $slide->orden) }}" required>
              @error('orden')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Descripción --}}
            <div class="col-12">
              <label for="descripcion" class="slide-form-label">Descripción</label>
              <textarea id="descripcion" name="descripcion" rows="2"
                        class="slide-form-input @error('descripcion') is-invalid @enderror">{{ old('descripcion', $slide->descripcion) }}</textarea>
              @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Imagen actual --}}
            <div class="col-12">
              <label class="slide-form-label">Imagen actual</label><br>
              @if($slide->imagen_ruta)
                <img src="{{ asset('storage/'.$slide->imagen_ruta) }}" class="img-preview" alt="Slide {{ $slide->id }}">
              @else
                <span class="text-muted">— Sin imagen —</span>
              @endif
            </div>

            {{-- Nueva imagen --}}
            <div class="col-12">
              <label for="imagen" class="slide-form-label mt-2">Subir nueva imagen</label>
              <input type="file" id="imagen" name="imagen"
                     class="slide-form-file @error('imagen') is-invalid @enderror"
                     accept="image/*">
              @error('imagen')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Botones --}}
          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-success me-2">Guardar cambios</button>
            <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
