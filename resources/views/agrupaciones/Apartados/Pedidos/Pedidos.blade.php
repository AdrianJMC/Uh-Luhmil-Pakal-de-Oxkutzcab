@extends('layouts.agrupaciones')

@section('title', 'Pedidos')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pedidos.css') }}">
@endpush

@section('content')
    <div class="container py-4">

        {{-- TABS --}}
        <ul class="nav nav-tabs mb-4 pedidos-tab" id="pedidosTabs" role="tablist">
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
                                    <th class="text-center">Ver Productos</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ $pedido->folio }}</td>
                                        <td>{{ $pedido->nombre_cliente }}</td>
                                        <td>{{ $pedido->telefono }}</td>
                                        <td class="text-center">
                                            <i class="fas fa-info-circle ms-2 mr-5 text-muted"
                                                title="Consulta los productos del pedido. Contacta directamente al cliente."></i>
                                            <a href="{{ route('agrupaciones.pedidos.ver', $pedido->pedido_id) }}"
                                                class="btn btn-sm btn-ver-pedido">
                                                <i class="fas fa-eye me-1"></i>
                                            </a>
                                        </td>
                                        <td>${{ number_format($pedido->total, 2) }}</td>
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
