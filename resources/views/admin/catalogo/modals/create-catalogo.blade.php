<div class="modal fade" id="modalCrearCatalogo" tabindex="-1" role="dialog" aria-labelledby="modalCrearCatalogoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('admin.catalogos.store') }}" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalCrearCatalogoLabel">Crear nuevo catálogo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Nombre --}}
                <div class="form-group">
                    <label for="nombre">Nombre del catálogo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        placeholder="Ej. Limones, Naranjas" required>
                </div>

                {{-- Imagen --}}
                <div class="form-group">
                    <label for="imagen">Imagen del catálogo</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*"
                        required>
                    <small class="form-text text-muted">Formato JPG, PNG. Máximo 5MB.</small>
                    @error('imagen')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-warning">Guardar catálogo</button>
            </div>
        </form>
    </div>
</div>
