<!-- resources/views/admin/Productos/modals/modal-eliminar-producto.blade.php -->
<div class="modal fade" id="modalEliminarProducto" tabindex="-1" role="dialog" aria-labelledby="modalEliminarProductoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content perfil-modal-card">
            <!-- Encabezado -->
            <div class="perfil-modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="modalEliminarProductoLabel">Eliminar Producto</h5>
                <button type="button" class="btn-cerrar-perfil-modal" data-dismiss="modal"
                    aria-label="Cerrar">&times;</button>
            </div>

            <!-- Cuerpo -->
            <div class="perfil-modal-body">
                <p class="mb-3">
                    ¿Estás seguro de que deseas eliminar el producto
                    <strong id="nombreProductoEliminar"></strong>?
                </p>
                <form method="POST" id="formEliminarProducto" class="d-flex justify-content-end gap-2" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-eliminar-perfil me-2">Sí, eliminar</button>
                    <button type="button" class="btn btn-cancelar-perfil" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
