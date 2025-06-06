{{-- Modal de eliminación con estilo personalizado --}}
<div class="modal fade" id="modalEliminarSlide" tabindex="-1" role="dialog" aria-labelledby="modalEliminarSlideLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content slide-form-card">
            {{-- Encabezado verde con "X" --}}
            <div class="slide-form-card-header d-flex justify-content-between align-items-center">
                <h2 class="modal-title m-0" id="modalEliminarSlideLabel">Eliminar Slide</h2>
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Cerrar">&times;</button>
            </div>

            <div class="slide-form-card-body">
                <form id="formEliminarSlide" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="mb-3">
                        ¿Estás seguro de que deseas eliminar este slide?
                    </p>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger me-2">Sí, eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
