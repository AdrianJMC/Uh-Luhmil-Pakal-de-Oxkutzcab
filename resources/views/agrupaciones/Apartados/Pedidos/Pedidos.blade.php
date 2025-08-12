@extends('layouts.agrupaciones')

@section('title', 'Pedidos')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pedidos.css') }}">
@endpush

@section('content')
    <div class="container py-4">

        {{-- TABS --}}
        <ul class="nav nav-tabs  pedidos-tab" id="pedidosTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="#">Pedidos Recibidos</a>
            </li>
        </ul>

        {{-- CONTENEDOR VISUAL COMO CARD --}}
        <div class="card-2 pedidos-card">
            <div class="alert alert-warning mb-3">
                Estos pedidos fueron realizados por clientes interesados. Ponte en contacto directamente para coordinar la
                entrega.
            </div>
            <div class="card-body p-0">
                @if ($pedidos->isEmpty())
                    <div class="alert alert-info m-0 p-3">No has recibido pedidos aún.</div>
                @else
                    {{-- Tabla para escritorio --}}
                    <div class="table-responsive d-none d-md-block">
                        <table class="table pedidos-table mb-0">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th class="text-center">Productos</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ $pedido->folio }}</td>
                                        <td>{{ $pedido->nombre_cliente }}</td>
                                        <td>{{ $pedido->telefono }}</td>
                                        @php
                                            // Obtener la cantidad de productos por pedido
                                            $cantidad = \App\Models\PedidoProducto::where(
                                                'pedido_id',
                                                $pedido->pedido_id,
                                            )
                                                ->where('agrupacion_id', Auth::guard('agrupacion')->id())
                                                ->count();
                                        @endphp

                                        <td class="text-center">
                                            <a href="{{ route('agrupaciones.pedidos.ver', $pedido->pedido_id) }}"
                                                class="link-productos-agrupacion" title="Ver productos del pedido">
                                                [{{ $cantidad }}] Productos
                                            </a>
                                        </td>
                                        <td>${{ number_format($pedido->total, 2) }} MXN</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Paginación afuera de la grilla --}}
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $pedidos->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    {{-- Vista móvil --}}
                    <div class="d-block d-md-none">
                        @include('partials.agrupaciones.pedidos-cards')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
