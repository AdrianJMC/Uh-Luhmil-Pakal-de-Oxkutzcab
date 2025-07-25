{{-- Modal para eliminar información importantes --}}

<div class="modal fade" id="modalEliminarInfo-{{ $info->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalEliminarLabel-{{ $info->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content info-form-card">
            <div class="info-form-card-header d-flex justify-content-between align-items-center">
                <h2 class="modal-title m-0" id="modalEliminarLabel-{{ $info->id }}">Eliminar info</h2>
                <button type="button" class="btn-close-custom" data-dismiss="modal" aria-label="Cerrar">
                    &times;
                </button>
            </div>
            <div class="info-form-card-body">
                <p class="mb-3">
                    ¿Estás seguro de que deseas eliminar esta información?<br>
                    <strong>{{ $info->titulo ?? 'Contenido de video' }}</strong>
                </p>
                <form method="POST" action="{{ route('admin.infos.destroy', $info) }}">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger me-2">Sí, eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
