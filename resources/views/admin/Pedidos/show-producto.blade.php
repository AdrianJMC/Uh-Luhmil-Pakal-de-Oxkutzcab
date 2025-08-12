<!-- Modal de Productos del Pedido -->
<div class="modal fade" id="modalProductosPedido{{ $pedido->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalLabel{{ $pedido->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $pedido->id }}">Productos del Pedido: {{ $pedido->folio }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body table-responsive">
                @php
                    $productos = $pedido->productos; // Relación productos cargada previamente
                @endphp

                @if ($productos->isEmpty())
                    <p class="text-muted text-center">No hay productos en este pedido.</p>
                @else
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Agrupación</th>
                                <th>Precio por Tonelada (MXN)</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $pp)
                                <tr>
                                    <td>{{ $pp->producto->nombre ?? 'Desconocido' }}</td>
                                    <td>{{ $pp->producto->agrupacion->nombre_agrupacion ?? 'Desconocida' }}</td>
                                    <td>${{ number_format($pp->precio_unitario, 2) }}</td>
                                    <td>{{ $pp->cantidad }} Ton</td>
                                    <td>${{ number_format($pp->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
