@foreach ($productosPendientes as $producto)
    <form id="form-aprobar-{{ $producto->id }}" action="{{ route('admin.productos.aprobar', $producto->id) }}"
        method="POST" style="display: none;">
        @csrf
    </form>
@endforeach
<div class="tab-pane fade" id="productos-pendientes" role="tabpanel" aria-labelledby="tab-pendientes">

    {{-- BUSCADOR --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="productos-title m-0">Productos Pendientes</h2>
        @can('buscar_productos')
            <form method="GET" class="position-relative" style="max-width: 490px; width: 100%;">
                <input type="hidden" name="tab" value="pendientes">
                <div class="input-group">
                    <input type="text" name="buscar" id="buscarProductosPendientes" value="{{ request('buscar') }}"
                        class="form-control" placeholder="Buscar por producto, categoría o agrupación" autocomplete="off"
                        oninput="mostrarSugerenciasProducto(this.value)">
                    <div class="input-group-append">
                        <button class="btn btn-warning" type="submit">Buscar</button>
                        <button class="btn btn-secondary" type="button"
                            onclick="limpiarBusquedaProducto()">Limpiar</button>
                    </div>
                </div>
                <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerenciasProductoPendientes"
                    style="z-index: 99; display: none;"></ul>
            </form>
        @endcan
    </div>


    {{-- CONTENEDOR ÚNICO PARA BOTONES --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        {{-- Izquierda: seleccionar / cancelar --}}
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" id="activarSeleccion">
                <i class="fas fa-check-square"></i> Seleccionar múltiples
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm d-none" id="cancelarSeleccion">
                <i class="fas fa-times"></i> Cancelar selección
            </button>
        </div>

        {{-- Derecha: aprobar / rechazar masivo --}}
        <div id="accionesMultiples" class="d-flex gap-2 d-none">
            @can('aprobar_productos_multiples')
                <button type="submit" form="form-multiples" formaction="{{ route('admin.productos.aprobar.multiples') }}"
                    class="btn-aprobar-multiples">
                    <i class="fas fa-check"></i> Aprobar seleccionados
                </button>
            @endcan

            @can('rechazar_productos_multiples')
                <button type="button" class="btn-rechazar-multiples" data-toggle="modal" data-target="#modalRechazoMasivo">
                    <i class="fas fa-times"></i> Rechazar seleccionados
                </button>
            @endcan
        </div>
    </div>


    {{-- FORMULARIO MASIVO: SOLO engloban los checkboxes y botones múltiple --}}
    <form id="form-multiples" method="POST">
        @csrf

        {{-- TABLA --}}
        <div class="card productos-tabla-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table productos-tabla-estilizada mb-0">
                        <thead>
                            <tr>
                                <th class="checkbox-col d-none" id="thCheckbox">
                                    <input type="checkbox" id="selectAll">
                                </th>
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
                            @forelse ($productosPendientes as $producto)
                                <tr>
                                    {{-- checkbox de selección múltiple --}}
                                    <td class="checkbox-col d-none">
                                        <input type="checkbox" name="productos[]" value="{{ $producto->id }}">
                                    </td>
                                    {{-- datos --}}
                                    <td>{{ $producto->id }}</td>
                                    <td>
                                        <img src="{{ $producto->imagen }}" alt=""
                                            style="width:55px; border-radius:6px;">
                                    </td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria }}</td>
                                    <td>{{ $producto->agrupacion->nombre_agrupacion ?? '-' }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td><span class="badge-pendiente">Pendiente</span></td>
                                    <td>{{ $producto->created_at->format('d/m/Y') }}</td>
                                    {{-- acciones individuales: cada botón en su propio form --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">

                                            @can('ver_detalles_producto')
                                                <!-- Botón Detalles -->
                                                <a href="{{ route('admin.productos.detalles', ['id' => $producto->id, 'tab' => 'pendientes']) }}"
                                                    class="btn-icon-detalles" title="Ver detalles">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('aprobar_producto')
                                                <!-- Aprobar -->
                                                <button type="submit" form="form-aprobar-{{ $producto->id }}"
                                                    class="btn-icon-aprobar" title="Aprobar">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            @endcan

                                            @can('rechazar_producto')
                                                <!-- Rechazar -->
                                                <form action="{{ route('admin.productos.rechazar', $producto->id) }}"
                                                    method="POST" class="m-0 p-0 d-inline">
                                                    @csrf
                                                    <button type="button" class="btn-icon-rechazar" title="Rechazar"
                                                        data-toggle="modal" data-target="#modalRechazo{{ $producto->id }}">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-3">
                                        No hay productos pendientes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </form>

    <div class="mt-4 d-flex justify-content-center">
        {{ $productosPendientes->links('pagination::bootstrap-4') }}
    </div>

    @include('admin.Productos.modals.modal-elimiar-producto')
    {{-- Modal de motivo de rechazo para productos individuales --}}
    @include('admin.Productos.modals.modal-motivo-rechazo')
    {{-- Modal de rechazo masivo para eliminar productos seleccionados --}}
    @include('admin.Productos.modals.modal-rechazo-masivo')

</div>
