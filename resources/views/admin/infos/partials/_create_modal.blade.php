<div class="modal fade" id="modalCrearInfo" tabindex="-1" aria-labelledby="modalCrearInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content info-form-card">
            <div class="info-form-card-header d-flex justify-content-between align-items-center">
                <h2 class="modal-title m-0" id="modalCrearInfoLabel">Nueva info</h2>
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Cerrar">
                    &times;
                </button>
            </div>


            <div class="info-form-card-body">
                <form action="{{ route('admin.infos.store') }}" method="POST" enctype="multipart/form-data"
                    id="info-form" novalidate>
                    @csrf

                    {{-- Switch: tipo video --}}
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_video" name="is_video"
                                {{ old('is_video') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_video">
                                Contenido tipo <strong>Video</strong> (YouTube/Vimeo)
                            </label>
                        </div>
                    </div>

                    <div class="row gx-3 gy-2">
                        {{-- Contenido normal (texto + imagen) --}}
                        <div id="campo-normal" class="col-12 row gx-3 gy-2 {{ old('is_video') ? 'd-none' : '' }}">
                            <div class="col-md-6">
                                <label for="titulo" class="form-label-highlight">Título</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="form-control-custom @error('titulo') is-invalid @enderror"
                                    value="{{ old('titulo') }}" {{ old('is_video') ? '' : 'required' }}>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="orden" class="form-label-highlight">Orden de aparición</label>
                                <input type="number" id="orden" name="orden"
                                    class="form-control-custom @error('orden') is-invalid @enderror"
                                    value="{{ old('orden', 0) }}" required>
                                @error('orden')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="texto" class="form-label-highlight">Descripción</label>
                                <textarea id="texto" name="texto" class="form-control-custom @error('texto') is-invalid @enderror" rows="2"
                                    {{ old('is_video') ? '' : 'required' }}>{{ old('texto') }}</textarea>
                                @error('texto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-highlight">Imagen <small
                                        class="text-muted">(obligatoria)</small></label>
                                <input type="file" name="imagen_normal" id="imagen_normal"
                                    class="form-control-file @error('imagen_normal') is-invalid @enderror"
                                    {{ old('is_video') ? '' : 'required' }} accept="image/*">
                                @error('imagen_normal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contenido video --}}
                        <div id="campo-video" class="col-12 row gx-3 gy-2 {{ old('is_video') ? '' : 'd-none' }}">
                            <div class="col-md-6">
                                <label for="video_id" class="form-label-highlight">ID Vídeo (YouTube/Vimeo)</label>
                                <input type="text" id="video_id" name="video_id"
                                    class="form-control-custom @error('video_id') is-invalid @enderror"
                                    value="{{ old('video_id') }}" required>
                                <small class="text-muted">Ej: WPsQ1_cIBrM</small>
                                @error('video_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="imagen_video" class="form-label-highlight">
                                    Miniatura personalizada <small class="text-muted">(opcional)</small>
                                </label>
                                <input type="file" name="imagen_video" id="imagen_video"
                                    class="form-control-file @error('imagen_video') is-invalid @enderror"
                                    accept="image/*">
                                <small class="text-muted">Imagen para la miniatura del video.</small>
                                @error('imagen_video')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="orden_video" class="form-label-highlight">Orden de aparición</label>
                                <input type="number" id="orden_video" name="orden"
                                    class="form-control-custom @error('orden') is-invalid @enderror"
                                    value="{{ old('orden', 0) }}" required>
                                @error('orden')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2">Crear Info</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCamposCreate() {
        const switchVideo = document.getElementById('is_video');
        const campoNormal = document.getElementById('campo-normal');
        const campoVideo = document.getElementById('campo-video');

        if (switchVideo.checked) {
            campoNormal.classList.add('d-none');
            campoVideo.classList.remove('d-none');

            // Quitar "required" a los campos de contenido normal
            document.getElementById('titulo')?.removeAttribute('required');
            document.getElementById('texto')?.removeAttribute('required');
            document.getElementById('imagen_normal')?.removeAttribute('required');

            // Agregar "required" al video
            document.getElementById('video_id')?.setAttribute('required', 'required');
        } else {
            campoNormal.classList.remove('d-none');
            campoVideo.classList.add('d-none');

            // Reagregar "required"
            document.getElementById('titulo')?.setAttribute('required', 'required');
            document.getElementById('texto')?.setAttribute('required', 'required');
            document.getElementById('imagen_normal')?.setAttribute('required', 'required');

            // Quitar "required" al video
            document.getElementById('video_id')?.removeAttribute('required');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const switchVideo = document.getElementById('is_video');
        if (switchVideo) {
            toggleCamposCreate(); // Aplica estado inicial
            switchVideo.addEventListener('change', toggleCamposCreate);
        }
    });
</script>
