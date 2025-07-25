@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')

@cannot('ver_pedidos')
    <div class="alert alert-danger p-4">No tienes permiso para ver esta sección.</div>
    @php exit; @endphp
@endcannot

@section('content')
    <div class="container-fluid py-4">
        {{-- Navegación entre pestañas --}}
        <ul class="nav nav-tabs mb-3" id="gestionPedidoTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link custom-tab active" id="pedidos-tab" data-toggle="tab" href="#pedidos" role="tab"
                    aria-controls="pedidos" aria-selected="true">Pedidos</a>
            </li>
        </ul>

        <div class="tab-content" id="gestionPedidoTabContent">
            {{-- TAB PEDIDOS --}}
            <div class="tab-pane fade show active" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">

                {{-- ENCABEZADO --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="pedido-title m-0">Listado de Pedidos</h2>
                </div>

                {{-- MENSAJE DE ÉXITO --}}
                @if (session('pedido_success'))
                    <div class="pedido-alert-success">{{ session('pedido_success') }}</div>
                @endif

                {{-- TABLA --}}
                <div class="card pedido-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table pedido-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Cliente</th>
                                        <th>Teléfono</th>
                                        <th>Total</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pedidos as $pedido)
                                        <tr>
                                            <td class="align-middle">{{ $pedido->folio }}</td>
                                            <td class="align-middle">{{ $pedido->nombre_cliente }}</td>
                                            <td class="align-middle">{{ $pedido->telefono }}</td>
                                            <td class="align-middle">${{ number_format($pedido->total, 2) }}</td>
                                            <td class="align-middle text-center">

                                                @can('ver_productos_pedido')
                                                    <a href="{{ route('admin.pedidos.ver-productos', $pedido->id) }}"
                                                        class="btn-ver-productos btn-sm d-flex flex-column align-items-center"
                                                        title="Ver productos del pedido">
                                                        <i class="fas fa-box-open icono-ver-productos mb-1"></i>
                                                        <span class="btn-ver-productos-text">Productos</span>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                No se encontraron pedidos.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Paginación --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $pedidos->links('pagination::bootstrap-4') }}
                </div>
            </div> {{-- FIN TAB --}}
        </div>
    </div>
@endsection
