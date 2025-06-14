<!-- Modal para confirmar eliminación de perfil -->
<div class="modal fade" id="eliminarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="eliminarPerfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content perfil-modal-card">
            <!-- Encabezado verde -->
            <div class="perfil-modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="eliminarPerfilModalLabel">Eliminar Perfil</h5>
                <button type="button" class="btn-cerrar-perfil-modal" data-dismiss="modal" aria-label="Cerrar">
                    &times;
                </button>
            </div>

            <!-- Cuerpo -->
            <div class="perfil-modal-body">
                <p class="mb-3">¿Estás seguro de que deseas eliminar este perfil?</p>
                <form method="POST" id="formEliminarPerfil" class="d-flex justify-content-end gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-eliminar-perfil me-2">Sí, eliminar</button>
                    <button type="button" class="btn btn-cancelar-perfil" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>



