@extends('layouts.admin')

@section('title', 'Gestión de Catálogos')

@section('content')
    <div class="container-fluid py-4">
        {{-- Navegación entre pestañas (una sola pestaña activa) --}}
        <ul class="nav nav-tabs mb-3" id="gestionCatalogoTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link custom-tab active" id="catalogo-tab" data-toggle="tab" href="#catalogo" role="tab"
                    aria-controls="catalogo" aria-selected="true">Catálogos</a>
            </li>
        </ul>

        <div class="tab-content" id="gestionCatalogoTabContent">
            {{-- TAB CATÁLOGOS --}}
            <div class="tab-pane fade show active" id="catalogo" role="tabpanel" aria-labelledby="catalogo-tab">

                {{-- ENCABEZADO --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="catalogo-title m-0">Gestión de Catálogos</h2>
                </div>

                {{-- MENSAJE DE ÉXITO --}}
                @if (session('catalogo_success'))
                    <div class="catalogo-alert-success">{{ session('catalogo_success') }}</div>
                @endif

                {{-- TABLA --}}
                <div class="card catalogo-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table catalogo-table mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del catálogo</th>
                                        <th>Imagen</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($catalogos as $catalogo)
                                        <tr>
                                            <td class="align-middle">{{ $catalogo->id }}</td>
                                            <td class="align-middle">{{ $catalogo->nombre }}</td>
                                            <td class="align-middle">
                                                @if ($catalogo->imagen_url)
                                                    <img src="{{ $catalogo->imagen_url }}" alt="Imagen catálogo"
                                                        width="60">
                                                @else
                                                    <span class="text-muted">Sin imagen</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div
                                                    class="catalogo-acciones d-flex justify-content-center flex-wrap gap-1">

                                                    @can('editar_catalogo')
                                                        {{-- Editar catálogo --}}
                                                        <a href="#" class="btn-editar-agrupacion btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modalEditarCatalogo-{{ $catalogo->id }}"
                                                            title="Editar">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan

                                                    @can('eliminar_catalogo')
                                                        {{-- Eliminar catálogo --}}
                                                        <button type="button" class="btn-eliminar-agrupacion btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modalEliminarCatalogo-{{ $catalogo->id }}"
                                                            title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">No se encontraron
                                                catálogos.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $catalogos->links('pagination::bootstrap-4') }}
                </div>

            </div> {{-- FIN TAB --}}
        </div>
    </div>

    {{-- BOTÓN FLOTANTE para crear nuevo catálogo --}}
    @can('crear_catalogo')
        <a href="#" class="btn btn-success rounded-circle position-fixed d-flex align-items-center justify-content-center"
            style="bottom: 20px; right: 20px; width: 50px; height: 50px; font-size: 28px; z-index: 1000;" data-toggle="modal"
            data-target="#modalCrearCatalogo">
            +
        </a>
    @endcan

    {{-- MODAL: Crear catálogo --}}
    @can('crear_catalogo')
        @include('admin.catalogo.modals.create-catalogo')
    @endcan

    @foreach ($catalogos as $catalogo)
        @can('editar_catalogo')
            @include('admin.catalogo.modals.edit-catalogo', ['catalogo' => $catalogo])
        @endcan

        @can('eliminar_catalogo')
            @include('admin.catalogo.modals.delete-catalogo', ['catalogo' => $catalogo])
        @endcan
    @endforeach
@endsection

@push('scripts')
    <script>
        $(function() {
            @if (session('create_error'))
                $('#modalCrearCatalogo').modal('show');
            @endif

            @if (session('edit_error_id'))
                $('#modalEditarCatalogo-{{ session('edit_error_id') }}').modal('show');
            @endif
        });
    </script>
@endpush
