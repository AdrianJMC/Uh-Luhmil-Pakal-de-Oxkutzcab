{{-- resources/views/admin/agrupaciones/_pendientes.blade.php --}}
<div class="tab-pane fade" id="agrupaciones-pendientes" role="tabpanel" aria-labelledby="tab-pendientes">

    {{-- BUSCADOR --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="agrupaciones-title m-0">Agrupaciones Pendientes</h2>
        @can('buscar_agrupaciones')
            <form method="GET" class="position-relative" style="max-width: 490px; width: 100%;">
                {{-- 👉 Esto preserva la pestaña actual --}}
                <input type="hidden" name="tab" value="pendientes">

                <div class="input-group">
                    <input type="text" name="buscar" id="buscarAgrupacionesPendientes" value="{{ request('buscar') }}"
                        class="form-control" placeholder="Buscar por agrupacion, representante o email" autocomplete="off"
                        oninput="mostrarSugerenciasAgrupacion(this.value)">
                    <div class="input-group-append">
                        <button class="btn btn-warning" type="submit">Buscar</button>
                        <button class="btn btn-secondary" type="button"
                            onclick="limpiarBusquedaAgrupacion()">Limpiar</button>
                    </div>
                </div>
                <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerenciasAgrupacionPendientes"
                    style="z-index: 99; display: none;"></ul>
            </form>
        @endcan
    </div>

    {{-- ALERTA --}}
    @if (session('success') && request('tab') === 'pendientes')
        <div class="agrupaciones-alert-success">Registro actualizado correctamente.</div>
    @endif

    {{-- TABLA AGRUPACIONES PENDIENTES --}}
    <div class="card agrupaciones-tabla-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table agrupaciones-tabla-estilizada mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Agrupación</th>
                            <th>Representante</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agrupacionesPendientes as $agrupacion)
                            <tr>
                                <td>{{ $agrupacion->id }}</td>
                                <td>{{ $agrupacion->nombre_agrupacion }}</td>
                                <td>{{ $agrupacion->nombre_representante }}</td>
                                <td>{{ $agrupacion->email_representante }}</td>
                                <td><span class="badge-pendiente">Pendiente</span></td>
                                <td>{{ $agrupacion->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    @can('ver_agrupacion_detalles')
                                        <a href="{{ route('admin.agrupaciones.detalles_agrupaciones', ['id' => $agrupacion->id, 'tab' => 'pendientes']) }}"
                                            class="btn-icon-detalles" title="Ver detalles">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
                                            </svg>
                                        </a>
                                    @endcan

                                    @can('aprobar_agrupacion')
                                        <form action="{{ route('admin.agrupaciones.aprobar', $agrupacion->id) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn-icon-aprobar" title="Aprobar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 10.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 8.439 6.03 6.97a.75.75 0 0 0-1.06 1.06l1.998 2z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endcan

                                    @can('rechazar_agrupacion')
                                        <form action="{{ route('admin.agrupaciones.rechazar', $agrupacion->id) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn-icon-rechazar" title="Rechazar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 0C5.371 0 0 5.371 0 12s5.371 12 12 12 12-5.371 12-12S18.629 0 12 0zm4.949 16.949a1 1 0 0 1-1.414 0L12 13.414l-3.535 3.535a1 1 0 0 1-1.414-1.414L10.586 12 7.05 8.465a1 1 0 1 1 1.414-1.414L12 10.586l3.535-3.535a1 1 0 0 1 1.414 1.414L13.414 12l3.535 3.535a1 1 0 0 1 0 1.414z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No hay agrupaciones pendientes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- PAGINACIÓN --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $agrupacionesPendientes->appends(request()->except('pendientes_page'))->fragment('agrupaciones-pendientes')->links('pagination::bootstrap-4') }}
    </div>
</div>
