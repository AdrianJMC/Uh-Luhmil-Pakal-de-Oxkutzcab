{{-- Modal para motivo de rechazo --}}
<div class="modal fade" id="modalRechazo{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="modalRechazoLabel{{ $producto->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('admin.productos.rechazar', $producto->id) }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRechazoLabel{{ $producto->id }}">Rechazar producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="motivo_rechazo">Motivo del rechazo:</label>
            <textarea name="motivo_rechazo" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Rechazar</button>
        </div>
      </div>
    </form>
  </div>
</div>
