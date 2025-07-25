@extends('layouts.admin')

@section('title', 'Productos del Pedido')

@section('content')
    <div class="container-fluid py-4 pedido-show-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="pedido-show-title m-0">Productos del Pedido: {{ $pedido->folio }}</h2>
        </div>

        <div class="row">
            @foreach ($paginados as $pp)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card pedido-show-card h-100 shadow-sm">
                        @if (!empty($pp->producto->imagen))
                            <img src="{{ $pp->producto->imagen }}" alt="Imagen del producto"
                                class="card-img-top pedido-show-img">
                        @else
                            <div class="pedido-show-no-image">
                                <span class="text-muted">Sin imagen</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column pedido-show-body">
                            <h5 class="card-title pedido-show-name">
                                {{ $pp->producto->nombre ?? 'Producto desconocido' }}
                            </h5>

                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted pedido-show-agrupacion">
                                    {{ $pp->producto->agrupacion->nombre_agrupacion ?? 'Agrupación desconocida' }}
                                </small>
                                <small class="text-muted pedido-show-precio">
                                    ${{ number_format($pp->precio_unitario, 2) }}/Ton
                                </small>
                            </div>

                            <div class="mt-auto">
                                <p class="mb-1"><strong>Cantidad:</strong> {{ $pp->cantidad }} Toneladas</p>
                                <p class="mb-0"><strong>Total:</strong> ${{ number_format($pp->total, 2) }} MXN</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $paginados->links('pagination::bootstrap-4') }}
        </div>

        <div class="text-right mt-3">
            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary pedido-show-back-btn">Volver</a>
        </div>
    </div>
@endsection
