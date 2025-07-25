@extends('layouts.admin')

@section('title', 'Gestión de Agrupaciones')

@section('content')
    <div class="container-fluid py-4">
        {{-- Navegación entre pestañas --}}
        <ul class="nav nav-tabs mb-3" id="tabsAgrupaciones" role="tablist">
            <li class="nav-item">
                <a class="nav-link agrupaciones-tab active" id="tab-registradas" data-toggle="tab"
                    href="#agrupaciones-registradas" role="tab" aria-controls="agrupaciones-registradas"
                    aria-selected="true">Agrupaciones Registradas</a>
            </li>
            <li class="nav-item">
                @php
                    $totalPendientes = $agrupacionesPendientes->count();
                @endphp

                <a class="nav-link agrupaciones-tab position-relative" id="tab-pendientes" data-toggle="tab"
                    href="#agrupaciones-pendientes" role="tab" aria-controls="agrupaciones-pendientes"
                    aria-selected="false">
                    Agrupaciones Pendientes

                    @if ($totalPendientes > 0)
                        <span class="badge badge-pendientes-count">
                            {{ $totalPendientes > 30 ? '30+' : $totalPendientes }}
                        </span>
                    @endif
                </a>
            </li>
        </ul>

        <div class="tab-content" id="tabContenidoAgrupaciones">
            {{-- TAB AGRUPACIONES REGISTRADAS --}}
            <div class="tab-pane fade show active" id="agrupaciones-registradas" role="tabpanel"
                aria-labelledby="tab-registradas">
                {{-- BUSCADOR --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="agrupaciones-title m-0">Gestión de Agrupaciones</h2>
                    @can('buscar_agrupaciones')
                        <form method="GET" class="position-relative" style="max-width: 490px; width: 100%;">
                            <div class="input-group">
                                <input type="text" name="buscar" id="buscarAgrupacionesRegistradas"
                                    value="{{ request('buscar') }}" class="form-control"
                                    placeholder="Buscar por agrupacion, representante o email" autocomplete="off"
                                    oninput="mostrarSugerenciasAgrupacion(this.value)">
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="submit">Buscar</button>
                                    <button class="btn btn-secondary" type="button"
                                        onclick="limpiarBusquedaAgrupacion()">Limpiar</button>
                                </div>
                            </div>
                            <ul class="list-group position-absolute w-100 mt-1 shadow" id="sugerenciasAgrupacionRegistradas"
                                style="z-index: 99; display: none;"></ul>
                        </form>
                    @endcan
                </div>

                @if (session('success') && request('tab') === null)
                    <div class="agrupaciones-alert-success">Registro actualizado correctamente.</div>
                @endif

                {{-- TABLA AGRUPACIONES --}}
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
                                    @php
                                        $filtro = request('buscar');
                                        $agrupacionesFiltradas = $agrupacionesRegistradas->filter(function ($a) use (
                                            $filtro,
                                        ) {
                                            return !$filtro ||
                                                str_contains(strtolower($a->nombre_agrupacion), strtolower($filtro)) ||
                                                str_contains(
                                                    strtolower($a->nombre_representante),
                                                    strtolower($filtro),
                                                ) ||
                                                str_contains(strtolower($a->email_representante), strtolower($filtro));
                                        });
                                    @endphp

                                    @forelse($agrupacionesRegistradas as $agrupacion)
                                        <tr>
                                            <td>{{ $agrupacion->id }}</td>
                                            <td>{{ $agrupacion->nombre_agrupacion }}</td>
                                            <td>{{ $agrupacion->nombre_representante }}</td>
                                            <td>{{ $agrupacion->email_representante }}</td>
                                            <td>
                                                @if ($agrupacion->estado === 'pendiente')
                                                    <span class="badge badge-warning">Pendiente</span>
                                                @elseif ($agrupacion->estado === 'aprobado')
                                                    <span class="badge-aprobado">Aprobado</span>
                                                @elseif ($agrupacion->estado === 'rechazado')
                                                    <span class="badge badge-danger">Rechazado</span>
                                                @endif
                                            </td>
                                            <td>{{ $agrupacion->created_at->format('d/m/Y') }}</td>
                                            <td class="text-center">
                                                <div
                                                    class="acciones-agrupaciones d-flex justify-content-center flex-wrap gap-1">
                                                    {{-- Detalles --}}
                                                    @can('ver_detalles_agrupacion')
                                                        <a href="{{ route('admin.agrupaciones.detalles_agrupaciones', ['id' => $agrupacion->id, 'tab' => 'registradas']) }}"
                                                            class="btn-icon-detalles" title="Ver detalles">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="currentColor">
                                                                <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
                                                            </svg>
                                                        </a>
                                                    @endcan

                                                    @can('editar_agrupacion')
                                                        {{-- Editar --}}
                                                        <a href="{{ route('admin.agrupaciones.edit', $agrupacion->id) }}"
                                                            class="btn-editar-agrupacion" title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan

                                                    @can('eliminar_agrupacion')
                                                        {{-- Eliminar --}}
                                                        <button type="button" class="btn-eliminar-agrupacion" title="Eliminar"
                                                            onclick="mostrarModalEliminarAgrupacion({{ $agrupacion->id }}, '{{ $agrupacion->nombre_agrupacion }}')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">No hay agrupaciones
                                                registradas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- PAGINACIÓN --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $agrupacionesRegistradas->appends(request()->except('registradas_page'))->fragment('agrupaciones-registradas')->links('pagination::bootstrap-4') }}
                </div>
            </div>

            {{-- TAB PENDIENTES DESDE PARCIAL --}}
            @include('admin.agrupaciones._pendientes', [
                'agrupacionesPendientes' => $agrupacionesPendientes,
            ])
        </div>
        @include('admin.agrupaciones.modals._modal_eliminar')
    </div>
@endsection

@php
    $agrupacionesRegistradasJson = $agrupacionesRegistradas->map(function ($a) {
        return [
            'id' => $a->id,
            'nombre_agrupacion' => $a->nombre_agrupacion,
            'nombre_representante' => $a->nombre_representante,
            'email_representante' => $a->email_representante,
        ];
    });

    $agrupacionesPendientesJson = $agrupacionesPendientes->map(function ($a) {
        return [
            'id' => $a->id,
            'nombre_agrupacion' => $a->nombre_agrupacion,
            'nombre_representante' => $a->nombre_representante,
            'email_representante' => $a->email_representante,
        ];
    });
@endphp

@push('scripts')
    <script>
        window.agrupacionesRegistradas = @json($agrupacionesRegistradasJson);
        window.agrupacionesPendientes = @json($agrupacionesPendientesJson);
    </script>

    <script src="{{ asset('js/Gestor-agrupaciones.js') }}"></script>
@endpush
