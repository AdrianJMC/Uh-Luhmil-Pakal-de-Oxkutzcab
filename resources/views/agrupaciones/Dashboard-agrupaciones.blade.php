@extends('layouts.agrupaciones')

@section('title', 'Dashboard de Agrupaciones')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ $totalPedidos }}</h3>
                            <p class="text-white font-weight-bold mb-0">Pedidos Recibidos</p>
                        </div>
                        <div class="icon text-white">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('agrupaciones.pedidos.index') }}" class="small-box-footer">Ver pedidos <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $totalProductos }}</h3>
                            <p class="text-white font-weight-bold mb-0">Productos Registrados</p>
                        </div>
                        <div class="icon text-white">
                            <i class="fas fa-box"></i>
                        </div>
                        <a href="{{ route('agrupaciones.productos.index') }}" class="small-box-footer">Ver productos <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">{{ $productosAprobados }}</h3>
                            <p class="text-white font-weight-bold mb-0">Productos Aprobados</p>
                        </div>
                        <div class="icon text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="{{ route('agrupaciones.productos.index') }}" class="small-box-footer">Ver catálogo <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="text-white font-weight-bold">${{ number_format($montoTotalVendido, 2) }}</h3>
                            <p class="text-white font-weight-bold mb-0">Total Vendido</p>
                        </div>
                        <div class="icon text-white">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="{{ route('agrupaciones.pedidos.index') }}" class="small-box-footer text-white">
                            Ver ventas <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ventas de los últimos 7 días -->
            <div class="grafica-card">
                <div class="grafica-header d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0 text-success font-weight-bold">📈 Ventas por Fecha</h5>
                    <form method="GET" action="{{ route('agrupaciones.dashboard') }}"
                        class="d-flex align-items-center gap-2">
                        <label for="rango" class="mb-0 mr-2 text-muted small d-none d-sm-block">Rango:</label>
                        <select name="rango" id="rango" onchange="this.form.submit()"
                            class="form-select-sm rounded border-success text-success font-weight-bold">
                            <option value="7" {{ request('rango') == 7 ? 'selected' : '' }}>Últimos 7 días</option>
                            <option value="30" {{ request('rango') == 30 ? 'selected' : '' }}>Últimos 30 días</option>
                        </select>
                    </form>
                </div>
                <div class="grafica-body">
                    <canvas id="ventasChart" height="120"></canvas>
                </div>
            </div>

            <!-- Últimos pedidos -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard-table-card">
                        <div class="card-header">
                            <h3 class="card-title">Últimos Pedidos Recibidos</h3>
                        </div>
                        <div class="card-body p-0">
                            @if ($ultimosPedidos->isEmpty())
                                <div class="p-3 text-muted">Aún no tienes pedidos recientes.</div>
                            @else
                                <!-- Versión de escritorio (tabla) -->
                                <div class="d-none d-md-block">
                                    <div class="table-responsive">
                                        <table class="table tabla-personalizada">
                                            <thead>
                                                <tr>
                                                    <th>Folio</th>
                                                    <th>Cliente</th>
                                                    <th>Teléfono</th>
                                                    <th>Total</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ultimosPedidos as $pedido)
                                                    <tr>
                                                        <td>{{ $pedido->folio }}</td>
                                                        <td>{{ $pedido->nombre_cliente }}</td>
                                                        <td>{{ $pedido->telefono }}</td>
                                                        <td>${{ number_format($pedido->total, 2) }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Versión móvil (tarjetas) -->
                                <div class="d-block d-md-none">
                                    @foreach ($ultimosPedidos as $pedido)
                                        <div class="pedido-card-mobile mb-3 p-3 border rounded shadow-sm">
                                            <p><strong>Folio:</strong> {{ $pedido->folio }}</p>
                                            <p><strong>Cliente:</strong> {{ $pedido->nombre_cliente }}</p>
                                            <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
                                            <p><strong>Total:</strong> ${{ number_format($pedido->total, 2) }}</p>
                                            <p><strong>Fecha:</strong>
                                                {{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    @endforeach
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center px-3 pb-3 mt-3">
                <a href="{{ route('agrupaciones.pedidos.index') }}" class="btn btn-sm btn-ver-pedidos px-4 py-2">
                    Ver todos los pedidos
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        window.labelsSemana = @json($labelsSemana);
        window.valoresSemana = @json($valoresSemana);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/Dashboard-agrupaciones/agrupacion-dashboard.js') }}"></script>
@endpush
