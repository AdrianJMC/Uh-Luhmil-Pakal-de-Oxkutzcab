@extends('layouts.agrupaciones')

@section('title', 'Productos del cliente')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Productos del cliente {{ $pedido->nombre_cliente }}</h2>

        @if ($productosPedido->isEmpty())
            <div class="alert alert-info">No se encontraron productos para este pedido.</div>
        @else
            <div class="row">
                @foreach ($productosPedido as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow border-success">
                            <img src="{{ asset($item->producto->imagen) }}" class="card-img-top"
                                alt="{{ $item->producto->nombre }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->producto->nombre }}</h5>
                                <p class="card-text mb-1">
                                    <strong>Precio por tonelada:</strong>
                                    ${{ number_format($item->precio_unitario, 2) }}<br>
                                    <strong>Cantidad solicitada:</strong> {{ $item->cantidad }} Toneladas<br>
                                    <strong>Total:</strong>
                                    ${{ number_format($item->precio_unitario * $item->cantidad, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $productosPedido->links('pagination::bootstrap-4') }}
            </div>
        @endif

        <div class="btn-align-right text-end mt-3">
            <a href="{{ route('agrupaciones.pedidos.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
@endsection
