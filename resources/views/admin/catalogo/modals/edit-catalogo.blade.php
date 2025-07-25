<div class="modal fade" id="modalEditarCatalogo-{{ $catalogo->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEditarCatalogoLabel-{{ $catalogo->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('admin.catalogos.update', $catalogo) }}" enctype="multipart/form-data"
            class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarCatalogoLabel-{{ $catalogo->id }}">
                    Editar catálogo #{{ $catalogo->id }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="nombre-{{ $catalogo->id }}">Nombre</label>
                    <input type="text" class="form-control" id="nombre-{{ $catalogo->id }}" name="nombre"
                        value="{{ old('nombre', $catalogo->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label>Imagen actual</label>
                    <div class="mb-2">
                        <img src="{{ $catalogo->imagen_url }}" alt="" width="80">
                    </div>
                    <label for="imagen-{{ $catalogo->id }}">Reemplazar imagen</label>
                    <input type="file" class="form-control-file" id="imagen-{{ $catalogo->id }}" name="imagen"
                        accept="image/*">
                    <small class="form-text text-muted">
                        Si no subes nada, se conservará la actual.
                    </small>
                    @error('imagen')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
