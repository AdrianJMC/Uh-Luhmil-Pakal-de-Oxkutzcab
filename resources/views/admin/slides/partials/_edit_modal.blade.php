{{-- Modal de edición de slide con estilo personalizado --}}
<div class="modal fade" id="modalEditarSlide" tabindex="-1" aria-labelledby="modalEditarSlideLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content slide-form-card">
            {{-- Header con estilo verde y botón cerrar --}}
            <div class="slide-form-card-header d-flex justify-content-between align-items-center">
                <h2 class="modal-title m-0" id="modalEditarSlideLabel">Editar Slide</h2>
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Cerrar">&times;</button>
            </div>

            <div class="slide-form-card-body">
                <form id="formEditarSlide" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row gx-3 gy-2">
                        <div class="col-md-6">
                            <label for="edit_titulo" class="slide-form-label">Título</label>
                            <input type="text" id="edit_titulo" name="titulo" class="slide-form-input form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_orden" class="slide-form-label">Orden</label>
                            <input type="number" id="edit_orden" name="orden" class="slide-form-input form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="edit_descripcion" class="slide-form-label">Descripción</label>
                            <textarea id="edit_descripcion" name="descripcion" rows="2" class="slide-form-input form-control"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="slide-form-label">Imagen actual</label><br>
                            <img id="edit_imagen_actual" src="" alt="Vista previa" class="img-preview mb-2" style="max-height: 180px;">
                        </div>
                        <div class="col-12">
                            <label for="edit_imagen" class="slide-form-label">Subir nueva imagen</label>
                            <input type="file" id="edit_imagen" name="imagen" class="slide-form-file form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-warning me-2">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
