<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarPedidoModal" tabindex="-1" aria-labelledby="confirmarPedidoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-confirmar-pedido" method="POST" action="{{ route('pedido.realizar') }}">
            @csrf
            <input type="hidden" name="total" value="{{ $total }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Pedido</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tu nombre</label>
                        <input type="text" name="nombre_cliente" class="form-control"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Tu número de teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-confirmar">Confirmar Pedido</button>
                </div>
            </div>
        </form>
    </div>
</div>
