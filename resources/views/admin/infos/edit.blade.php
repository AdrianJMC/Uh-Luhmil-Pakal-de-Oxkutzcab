{{-- resources/views/admin/infos/edit.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid">

  {{-- ALERTA DE ÉXITO (se oculta a los 3 segundos) --}}
  @if (session('success'))
    <div
      id="success-alert"
      class="alert alert-success alert-dismissible fade show"
      role="alert"
      style="position: relative; margin-bottom: 1rem;"
    >
      {{ session('success') }}
    </div>
  @endif
  {{-- /ALERTA DE ÉXITO --}}

  {{-- Card principal --}}
  <div class="info-form-card">
    {{-- Encabezado verde --}}
    <div class="info-form-card-header">
      <h2>{{ isset($info) ? 'Editar info' : 'Nueva info' }}</h2>
    </div>

    {{-- Cuerpo del card --}}
    <div class="info-form-card-body">
      <form
        action="{{ isset($info) 
                    ? route('admin.infos.update', $info) 
                    : route('admin.infos.store') }}"
        method="POST"
        enctype="multipart/form-data"
        id="info-form"
        novalidate
      >
        @csrf
        @if(isset($info)) @method('PUT') @endif

        {{-- ---------- SWITCH: ¿Es video? ---------- --}}
        <div class="mb-3">
          <div class="form-check form-switch">
            <input
              class="form-check-input"
              type="checkbox"
              id="is_video"
              name="is_video"
              {{ old('is_video', isset($info) && $info->video_id ? 'checked' : '') }}
            >
            <label class="form-check-label" for="is_video">
              Contenido tipo <strong>Video</strong> (YouTube/Vimeo)
            </label>
          </div>
        </div>

        {{-- ---------- Campos en dos columnas ---------- --}}
        <div class="row gx-3 gy-2">
          {{-- ========= CONTENIDO NORMAL ========= --}}
          <div id="campo-normal"
               class="col-12 row gx-3 gy-2 {{ old('is_video') || (isset($info) && $info->video_id) ? 'd-none' : '' }}">
            {{-- Título --}}
            <div class="col-md-6">
              <label for="titulo" class="form-label-highlight">Título</label>
              <input
                type="text"
                id="titulo"
                name="titulo"
                class="form-control-custom @error('titulo') is-invalid @enderror"
                value="{{ old('titulo', $info->titulo ?? '') }}"
                {{ old('is_video') || (isset($info) && $info->video_id) ? '' : 'required' }}
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
                value="{{ old('orden', $info->orden ?? 0) }}"
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
                {{ old('is_video') || (isset($info) && $info->video_id) ? '' : 'required' }}
              >{{ old('texto', $info->texto ?? '') }}</textarea>
              @error('texto')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Imagen obligatoria --}}
            <div class="col-md-6">
              <label class="form-label-highlight">
                Imagen <small class="text-muted">(obligatoria)</small>
              </label>

              @if(isset($info) && $info->imagen_ruta && ! $info->video_id)
                <div class="mb-1">
                  <img
                    src="{{ asset('storage/' . $info->imagen_ruta) }}"
                    alt="Vista previa"
                    class="img-preview"
                    style="max-width: 200px; max-height: 150px;"
                  >
                </div>
              @endif

              <input
                type="file"
                name="imagen_normal"
                id="imagen_normal"
                class="form-control-file @error('imagen_normal') is-invalid @enderror"
                {{ old('is_video') || (isset($info) && $info->video_id) ? '' : 'required' }}
              >
              @error('imagen_normal')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          {{-- /.campo-normal --}}

          {{-- ========= SOLO VIDEO ========= --}}
          <div id="campo-video"
               class="col-12 row gx-3 gy-2 {{ old('is_video') || (isset($info) && $info->video_id) ? '' : 'd-none' }}">
            {{-- ID Vídeo --}}
            <div class="col-md-6">
              <label for="video_id" class="form-label-highlight">ID Vídeo (YouTube/Vimeo)</label>
              <input
                type="text"
                id="video_id"
                name="video_id"
                class="form-control-custom @error('video_id') is-invalid @enderror"
                value="{{ old('video_id', $info->video_id ?? '') }}"
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
                Miniatura personalizada <small class="text-muted"></small>
              </label>

              @if(isset($info) && $info->imagen_ruta && $info->video_id)
                <div class="mb-1">
                  <img
                    src="{{ asset('storage/' . $info->imagen_ruta) }}"
                    alt="Vista previa"
                    class="img-preview"
                    style="max-width: 200px; max-height: 150px;"
                  >
                </div>
              @endif

              <input
                type="file"
                name="imagen_video"
                id="imagen_video"
                class="form-control-file @error('imagen_video') is-invalid @enderror"
              >
              <small class="text-muted">
                Imagen para la minitura del video.
              </small>
              @error('imagen_video')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            {{-- Orden --}}
            <div class="col-md-6">
              <label for="orden_video" class="form-label-highlight">Orden de aparición</label>
              <input
                type="number"
                id="orden_video"
                name="orden"
                class="form-control-custom @error('orden') is-invalid @enderror"
                value="{{ old('orden', $info->orden ?? 0) }}"
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
          <button type="submit" class="btn btn-success me-2">
            {{ isset($info) ? 'Actualizar' : 'Crear' }}
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
    // === LÓGICA PARA MOSTRAR/UOCULTAR CAMPOS NORMAL vs VIDEO ===
    const switchVideo     = document.getElementById('is_video');
    const campoNormal     = document.getElementById('campo-normal');
    const campoVideo      = document.getElementById('campo-video');

    function toggleCampos() {
      if (switchVideo.checked) {
        campoNormal.classList.add('d-none');
        campoVideo.classList.remove('d-none');

        // Quitar required de campos “normal”
        document.getElementById('titulo')?.removeAttribute('required');
        document.getElementById('texto')?.removeAttribute('required');
        document.getElementById('imagen_normal')?.removeAttribute('required');

        // Poner required en campo “video”
        document.getElementById('video_id')?.setAttribute('required','required');
      } else {
        campoNormal.classList.remove('d-none');
        campoVideo.classList.add('d-none');

        // Poner required en campos “normal”
        document.getElementById('titulo')?.setAttribute('required','required');
        document.getElementById('texto')?.setAttribute('required','required');
        document.getElementById('imagen_normal')?.setAttribute('required','required');

        // Quitar required de “video”
        document.getElementById('video_id')?.removeAttribute('required');
      }
    }

    // Al cargar la página, aplicamos el estado inicial
    toggleCampos();
    // Al cambiar el switch, alternamos campos
    switchVideo.addEventListener('change', toggleCampos);


    // === LÓGICA PARA QUE LA ALERTA DESAPAREZCA A LOS 3 SEGUNDOS ===
    const alertSuccess = document.getElementById('success-alert');
    if (alertSuccess) {
      // Después de 3 segundos, ocultamos la alerta (Bootstrap 5 fade + d-none)
      setTimeout(() => {
        // Podemos quitar la clase "show" y agregar "fade" o simplemente ocultarlo:
        alertSuccess.classList.remove('show');
        alertSuccess.classList.add('fade');
        // Luego, después de que termine el fade (0.15s), agregamos d-none
        setTimeout(() => {
          alertSuccess.classList.add('d-none');
        }, 150);
      }, 3000);
    }
  });
</script>
@endsection
