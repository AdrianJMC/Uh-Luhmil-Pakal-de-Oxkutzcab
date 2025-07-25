 {{-- MODAL RECHAZO MASIVO --}}
    <div class="modal fade" id="modalRechazoMasivo" tabindex="-1" role="dialog" aria-labelledby="modalRechazoMasivoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('admin.productos.rechazar.multiples') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRechazoMasivoLabel">Rechazar productos seleccionados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="productos_ids" id="productosSeleccionadosInput">
                        <div class="form-group">
                            <label for="motivoRechazoMasivo">Motivo del rechazo</label>
                            <textarea name="motivo_rechazo" id="motivoRechazoMasivo" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Rechazar seleccionados</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>