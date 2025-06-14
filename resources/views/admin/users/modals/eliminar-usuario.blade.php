<!-- Modal para confirmar eliminación de usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content perfil-modal-card">
            <div class="perfil-modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="modalEliminarUsuarioLabel">Eliminar Usuario</h5>
                <button type="button" class="btn-cerrar-perfil-modal" data-dismiss="modal" aria-label="Cerrar">
                    &times;
                </button>
            </div>
            <div class="perfil-modal-body">
                <p class="mb-3">¿Estás seguro de que deseas eliminar este usuario?</p>
                <form method="POST" id="formEliminarUsuario" class="d-flex justify-content-end gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-eliminar-perfil me-2">Sí, eliminar</button>
                    <button type="button" class="btn btn-cancelar-perfil" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
