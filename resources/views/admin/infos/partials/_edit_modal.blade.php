<!-- resources/views/admin/infos/partials/_edit_modal.blade.php -->
<div class="modal fade" id="modalEditarInfo-{{ $info->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarInfoLabel-{{ $info->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 900px;">

        <div class="modal-content info-form-card">
            <div class="info-form-card-header d-flex justify-content-between align-items-center">
                <h2 class="modal-title m-0" id="modalEditarInfoLabel-{{ $info->id }}">Editar info</h2>
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Cerrar">
                    &times;
                </button>
            </div>


            <div class="info-form-card-body">
                <form action="{{ route('admin.infos.update', $info) }}" method="POST" enctype="multipart/form-data"
                    id="formEditarInfo-{{ $info->id }}" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- ---------- SWITCH: ¿Es video? ---------- --}}
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="is_video"
                                id="edit_is_video_{{ $info->id }}" {{ $info->video_id ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_is_video_{{ $info->id }}">
                                Contenido tipo <strong>Video</strong> (YouTube/Vimeo)
                            </label>
                        </div>
                    </div>

                    <div class="row gx-3 gy-2">
                        {{-- ========= CONTENIDO NORMAL ========= --}}
                        <div id="edit-campo-normal-{{ $info->id }}"
                            class="col-12 row gx-3 gy-2 {{ $info->video_id ? 'd-none' : '' }}">
                            <div class="col-md-6">
                                <label for="edit_titulo_{{ $info->id }}"
                                    class="form-label-highlight">Título</label>
                                <input type="text" name="titulo" id="edit_titulo_{{ $info->id }}"
                                    class="form-control-custom" value="{{ $info->titulo }}">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_orden_{{ $info->id }}" class="form-label-highlight">Orden</label>
                                <input type="number" name="orden" id="edit_orden_{{ $info->id }}"
                                    class="form-control-custom" value="{{ $info->orden }}">
                            </div>
                            <div class="col-12">
                                <label for="edit_texto_{{ $info->id }}"
                                    class="form-label-highlight">Descripción</label>
                                <textarea name="texto" id="edit_texto_{{ $info->id }}" class="form-control-custom" rows="2">{{ $info->texto }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-highlight">Imagen actual</label><br>
                                <img src="{{ asset('storage/' . $info->imagen_ruta) }}" alt="Vista previa"
                                    class="img-preview" style="max-width: 200px; max-height: 150px;">
                                <input type="file" name="imagen_normal" class="form-control-file mt-2">
                            </div>
                        </div>

                        {{-- ========= SOLO VIDEO ========= --}}
                        <div id="edit-campo-video-{{ $info->id }}"
                            class="col-12 row gx-3 gy-2 {{ $info->video_id ? '' : 'd-none' }}">
                            <div class="col-md-6">
                                <label for="edit_video_id_{{ $info->id }}" class="form-label-highlight">ID
                                    Vídeo</label>
                                <input type="text" name="video_id" id="edit_video_id_{{ $info->id }}"
                                    class="form-control-custom" value="{{ $info->video_id }}">
                                <small class="text-muted">Ej: WPsQ1_cIBrM</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-highlight">Miniatura actual</label><br>
                                <img src="{{ asset('storage/' . $info->imagen_ruta) }}" alt="Vista previa"
                                    class="img-preview" style="max-width: 200px; max-height: 150px;">
                                <input type="file" name="imagen_video" class="form-control-file mt-2">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_orden_video_{{ $info->id }}"
                                    class="form-label-highlight">Orden</label>
                                <input type="number" name="orden" id="edit_orden_video_{{ $info->id }}"
                                    class="form-control-custom" value="{{ $info->orden }}">
                            </div>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const switchEdit{{ $info->id }} = document.getElementById('edit_is_video_{{ $info->id }}');
        const campoNormal{{ $info->id }} = document.getElementById(
            'edit-campo-normal-{{ $info->id }}');
        const campoVideo{{ $info->id }} = document.getElementById('edit-campo-video-{{ $info->id }}');

        function toggleCamposEdit{{ $info->id }}() {
            if (switchEdit{{ $info->id }}.checked) {
                campoNormal{{ $info->id }}.classList.add('d-none');
                campoVideo{{ $info->id }}.classList.remove('d-none');
            } else {
                campoNormal{{ $info->id }}.classList.remove('d-none');
                campoVideo{{ $info->id }}.classList.add('d-none');
            }
        }

        toggleCamposEdit{{ $info->id }}();
        switchEdit{{ $info->id }}.addEventListener('change', toggleCamposEdit{{ $info->id }});
    });
</script>
