<div class="modal fade" id="modalEliminarCatalogo-{{ $catalogo->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEliminarCatalogoLabel-{{ $catalogo->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('admin.catalogos.destroy', $catalogo) }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalEliminarCatalogoLabel-{{ $catalogo->id }}">
                    Eliminar catálogo
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>¿Estás seguro que deseas eliminar el catálogo <strong>{{ $catalogo->nombre }}</strong>?<br>
                    Esta acción no se puede deshacer</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
        </form>
    </div>
</div>
