@extends('layouts.admin')

@section('title', 'Gestión de Productos')

@section('content')
    <div class="container-fluid py-4">
        {{-- PESTAÑAS --}}
        <ul class="nav nav-tabs mb-3" id="tabsProductos" role="tablist">
            <li class="nav-item">
                <a class="nav-link productos-tab active" id="tab-aprobados" data-toggle="tab" href="#productos-aprobados"
                    role="tab" aria-controls="productos-aprobados" aria-selected="true">Productos Aprobados</a>
            </li>
            <li class="nav-item">
                @php $totalPendientes = $productosPendientes->count(); @endphp
                <a class="nav-link productos-tab position-relative" id="tab-pendientes" data-toggle="tab"
                    href="#productos-pendientes" role="tab" aria-controls="productos-pendientes" aria-selected="false">
                    Productos Pendientes
                    @if ($totalPendientes > 0)
                        <span
                            class="badge badge-pendientes-count">{{ $totalPendientes > 30 ? '30+' : $totalPendientes }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <div class="tab-content" id="tabContenidoProductos">

            {{-- TAB Aprobados --}}
            <div class="tab-pane fade show active" id="productos-aprobados" role="tabpanel" aria-labelledby="tab-aprobados">
                {{-- BUSCADOR --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="productos-title m-0">Gestión de Productos</h2>
                    @can('buscar_productos')
                        <form method="GET" class="position-relative" style="max-width: 490px; width: 100%;">
                            <div class="input-group">
                                <input type="text" name="buscar" id="buscarProductosAprobados"
                                    value="{{ request('buscar') }}" class="form-control"
                                    placeholder="Buscar por producto, categoría o agrupación" autocomplete="off"
                                    oninput="mostrarSugerenciasProducto(this.value)">
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit">Buscar</button>
                                    <button class="btn btn-secondary" type="button"
                                        onclick="limpiarBusquedaProducto()">Limpiar</button>
                                </div>
                            </div>
                            <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerenciasProductoAprobados"
                                style="z-index: 99; display: none;"></ul>
                        </form>
                    @endcan
                </div>

                @if (session('success') && request('tab') === null)
                    <div class="productos-alert-success">Registro actualizado correctamente.</div>
                @endif

                {{-- TABLA APROBADOS --}}
                <div class="card productos-tabla-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table productos-tabla-estilizada mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Agrupación</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Registro</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productosAprobados as $producto)
                                        <tr>
                                            <td>{{ $producto->id }}</td>
                                            <td>
                                                <img src="{{ $producto->imagen }}" alt="Imagen del producto"
                                                    style="width: 55px; height: auto; border-radius: 6px;">
                                            </td>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>{{ $producto->categoria }}</td>
                                            <td>{{ $producto->agrupacion->nombre_agrupacion ?? '-' }}</td>
                                            <td>${{ number_format($producto->precio, 2) }}</td>
                                            <td><span class="badge-aprobado">Aprobado</span></td>
                                            <td>{{ $producto->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <div
                                                    class="acciones-productos d-flex justify-content-center flex-wrap gap-1">

                                                    @can('ver_detalles_producto')
                                                        <!-- Detalles -->
                                                        <a href="{{ route('admin.productos.detalles', ['id' => $producto->id, 'tab' => 'aprobados']) }}"
                                                            class="btn-icon-detalles" title="Ver detalles">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
                                                            </svg>
                                                        </a>
                                                    @endcan

                                                    @can('editar_producto')
                                                        <!-- Editar -->
                                                        <a href="{{ route('admin.productos.edit', ['id' => $producto->id, 'tab' => 'aprobados']) }}"
                                                            class="btn-editar-producto" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan

                                                    @can('eliminar_producto')
                                                        <!-- Eliminar -->
                                                        <button type="button" class="btn-eliminar-producto" title="Eliminar"
                                                            onclick="mostrarModalEliminarProducto({{ $producto->id }}, '{{ $producto->nombre }}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                    @include('admin.Productos.modals.modal-elimiar-producto')
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-3">No hay productos
                                                registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $productosAprobados->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>

            {{-- TAB Pendientes: se incluye desde el parcial --}}
            @include('admin.productos._productos-pendientes', [
                'productosPendientes' => $productosPendientes,
            ])
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Exponemos los datos solo en esta página
        window.productosAprobados = {!! json_encode(
            $productosAprobados->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'nombre' => $p->nombre,
                        'categoria' => $p->categoria,
                        'agrupacion' => optional($p->agrupacion)->nombre_agrupacion ?? '',
                    ];
                })->values(),
        ) !!};

        window.productosPendientes = {!! json_encode(
            $productosPendientes->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'nombre' => $p->nombre,
                        'categoria' => $p->categoria,
                        'agrupacion' => optional($p->agrupacion)->nombre_agrupacion ?? '',
                    ];
                })->values(),
        ) !!};
    </script>

    <!-- Cargamos el bundle solo en esta página -->
    <script src="{{ asset('js/Gestor-Productos.js') }}"></script>
@endpush
