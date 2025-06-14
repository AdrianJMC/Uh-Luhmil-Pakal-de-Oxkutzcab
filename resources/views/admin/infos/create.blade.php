{{-- resources/views/admin/infos/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="info-form-card">
    <div class="info-form-card-header">
      <h2>Nueva info</h2>
    </div>

    <div class="info-form-card-body">
      <form
        action="{{ route('admin.infos.store') }}"
        method="POST"
        enctype="multipart/form-data"
        id="info-form"
        novalidate
      >
        @csrf

        {{-- ---------- SWITCH: ¿Contenido tipo Video? ---------- --}}
        <div class="mb-3">
          <div class="form-check form-switch">
            <input
              class="form-check-input"
              type="checkbox"
              id="is_video"
              name="is_video"
              {{ old('is_video') ? 'checked' : '' }}
            >
            <label class="form-check-label" for="is_video">
              Contenido tipo <strong>Video</strong> (YouTube/Vimeo)
            </label>
          </div>
        </div>

        {{-- ---------- Campos en dos columnas ---------- --}}
        <div class="row gx-3 gy-2">
          {{-- ========= CONTENIDO NORMAL (imagen + título + descripción) ========= --}}
          <div id="campo-normal" class="col-12 row gx-3 gy-2 {{ old('is_video') ? 'd-none' : '' }}">
            {{-- Título --}}
            <div class="col-md-6">
              <label for="titulo" class="form-label-highlight">Título</label>
              <input
                type="text"
                id="titulo"
                name="titulo"
                class="form-control-custom @error('titulo') is-invalid @enderror"
                value="{{ old('titulo') }}"
                {{ old('is_video') ? '' : 'required' }}
              >
              @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Orden --}}
            <div class="col-md-6">
              <label for="orden" class="form-label-highlight">Orden de aparición</label>
              <input
                type="number"
                id="orden"
                name="orden"
                class="form-control-custom @error('orden') is-invalid @enderror"
                value="{{ old('orden', 0) }}"
                required
              >
              @error('orden')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Descripción --}}
            <div class="col-12">
              <label for="texto" class="form-label-highlight">Descripción</label>
              <textarea
                id="texto"
                name="texto"
                class="form-control-custom @error('texto') is-invalid @enderror"
                rows="2"
                {{ old('is_video') ? '' : 'required' }}
              >{{ old('texto') }}</textarea>
              @error('texto')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Imagen obligatoria --}}
            <div class="col-md-6">
              <label class="form-label-highlight">
                Imagen <small class="text-muted">(obligatoria)</small>
              </label>
              <input
                type="file"
                name="imagen_normal"
                id="imagen_normal"
                class="form-control-file @error('imagen_normal') is-invalid @enderror"
                {{ old('is_video') ? '' : 'required' }}
                accept="image/*"
              >
              @error('imagen_normal')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          {{-- /.campo-normal --}}

          {{-- ========= SOLO VIDEO ========= --}}
          <div id="campo-video" class="col-12 row gx-3 gy-2 {{ old('is_video') ? '' : 'd-none' }}">
            {{-- ID Vídeo --}}
            <div class="col-md-6">
              <label for="video_id" class="form-label-highlight">ID Vídeo (YouTube/Vimeo)</label>
              <input
                type="text"
                id="video_id"
                name="video_id"
                class="form-control-custom @error('video_id') is-invalid @enderror"
                value="{{ old('video_id') }}"
                required
              >
              <small class="text-muted">Ej: WPsQ1_cIBrM</small>
              @error('video_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Miniatura opcional --}}
            <div class="col-md-6">
              <label for="imagen_video" class="form-label-highlight">
                Miniatura personalizada <small class="text-muted">(opcional)</small>
              </label>
              <input
                type="file"
                name="imagen_video"
                id="imagen_video"
                class="form-control-file @error('imagen_video') is-invalid @enderror"
                accept="image/*"
              >
              <small class="text-muted">
                Imagen para la miniatura del video.
              </small>
              @error('imagen_video')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            {{-- Orden (para video también obligatorio) --}}
            <div class="col-md-6">
              <label for="orden_video" class="form-label-highlight">Orden de aparición</label>
              <input
                type="number"
                id="orden_video"
                name="orden"
                class="form-control-custom @error('orden') is-invalid @enderror"
                value="{{ old('orden', 0) }}"
                required
              >
              @error('orden')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          {{-- /.campo-video --}}
        </div>
        {{-- /.row --}}

        {{-- ---------- Botones ---------- --}}
        <div class="d-flex justify-content-end mt-3">
          <button type="submit" class="btn btn-warning me-2">
            Crear
          </button>
          <a href="{{ route('admin.infos.index') }}" class="btn btn-secondary">
            Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

{{-- Script para alternar los paneles “normal” ↔ “video” --}}
@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const switchVideo = document.getElementById('is_video');
    const campoNormal = document.getElementById('campo-normal');
    const campoVideo = document.getElementById('campo-video');

    function toggleCampos() {
      if (switchVideo.checked) {
        // Modo video: ocultamos “campo-normal”, mostramos “campo-video”
        campoNormal.classList.add('d-none');
        campoVideo.classList.remove('d-none');

        // Campos “contenido normal” dejan de ser required
        document.getElementById('titulo')?.removeAttribute('required');
        document.getElementById('texto')?.removeAttribute('required');
        document.getElementById('imagen_normal')?.removeAttribute('required');

        // Campos “solo video” pasan a required
        document.getElementById('video_id')?.setAttribute('required', 'required');
      } else {
        // Modo “imagen + texto”: mostramos “campo-normal”, ocultamos “campo-video”
        campoNormal.classList.remove('d-none');
        campoVideo.classList.add('d-none');

        // Campos “contenido normal” vuelven a ser required
        document.getElementById('titulo')?.setAttribute('required', 'required');
        document.getElementById('texto')?.setAttribute('required', 'required');
        document.getElementById('imagen_normal')?.setAttribute('required', 'required');

        // Campos “solo video” ya no son required
        document.getElementById('video_id')?.removeAttribute('required');
      }
    }

    // Al cargar la página, aplicamos el estado inicial
    toggleCampos();
    // Cuando cambie el switch, alternamos paneles
    switchVideo.addEventListener('change', toggleCampos);
  });
</script>
@endsection
