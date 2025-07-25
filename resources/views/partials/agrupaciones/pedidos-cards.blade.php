{{-- Vista móvil --}}
<div class="d-block d-md-none">
    @foreach ($pedidos as $pedido)
        <a href="{{ route('agrupaciones.pedidos.ver', $pedido->pedido_id) }}" class="text-decoration-none">
            <div class="mb-3 pedido-card-mobile-1 card shadow border-0">
                <div class="card-body">
                    <h5 class="pedido-folio mb-2">
                        <i class="fas fa-receipt me-1"></i>
                        Folio: <span>{{ $pedido->folio }}</span>
                    </h5>
                    <p class="pedido-datos mb-0">
                        <strong>Cliente:</strong> {{ $pedido->nombre_cliente }}<br>
                        <strong>Teléfono:</strong> {{ $pedido->telefono }}<br>
                        <strong>Total:</strong> ${{ number_format($pedido->total, 2) }}
                    </p>
                </div>
            </div>
        </a>
    @endforeach

    {{-- Paginación general --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $pedidos->links('pagination::bootstrap-4') }}
    </div>
</div>
