@extends('layouts.admin')

@cannot('ver_slides')
    <div class="alert alert-danger p-4">
        No tienes permiso para ver esta sección.
    </div>
    @php exit; @endphp
@endcannot

@section('content')
    <div class="container-fluid py-4 position-relative">
        <h2 class="page-title mb-4 d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('admin.pages.index') }}#pane-inicio" class="back-circle" title="Volver a Secciones Web">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                    class="bi bi-arrow-left back-arrow-icon" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
            </a>
            Slides del Home

            <span class="badge bg-warning text-white" id="slide-count">{{ $slides->count() }}</span>

            @if ($slides->count() >= 6)
                <span id="slide-limit-alert" class="badge-slide-limit">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Máximo 6 slides
                </span>
            @endif
        </h2>

        {{-- Mensajes --}}
        @if (session('success'))
            <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div id="error-alert" class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Tabla --}}
        <div class="card page-edit-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($slides as $slide)
                                <tr>
                                    <td class="align-middle">{{ $slide->titulo }}</td>
                                    <td class="align-middle">{{ \Illuminate\Support\Str::limit($slide->descripcion, 50) }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($slide->imagen_ruta)
                                            <img src="{{ $slide->imagen_ruta }}" alt="slide" class="img-preview">
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-actions-horizontal">
                                            @can('editar_slides')
                                                <button type="button" class="btn-editar-verde btn btn-sm" data-toggle="modal"
                                                    data-target="#modalEditarSlide" data-id="{{ $slide->id }}"
                                                    data-titulo="{{ $slide->titulo }}"
                                                    data-descripcion="{{ $slide->descripcion }}"
                                                    data-orden="{{ $slide->orden }}" data-imagen="{{ $slide->imagen_ruta }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            @endcan


                                            <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar este slide?')">
                                                @csrf
                                                @method('DELETE')
                                                @can('eliminar_slides')
                                                    <button type="button" class="btn btn-sm btn-danger btn-open-delete-modal"
                                                        data-toggle="modal" data-target="#modalEliminarSlide"
                                                        data-id="{{ $slide->id }}"><i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No hay slides cargados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Botón flotante para agregar slide --}}
        @can('crear_slides')
            @if ($slides->count() < 6)
                <button class="btn btn-success rounded-circle shadow-lg position-fixed"
                    style="bottom: 20px; right: 20px; width: 55px; height: 55px; z-index: 1050;" data-toggle="modal"
                    data-target="#modalCrearSlide" title="Nuevo Slide">
                    <i class="fas fa-plus"></i>
                </button>
            @endif
        @endcan

        {{-- Modales --}}
        @can('crear_slides')
            @include('admin.slides.partials._create_modal')
        @endcan

        @can('editar_slides')
            @include('admin.slides.partials._edit_modal')
        @endcan

        @can('eliminar_slides')
            @include('admin.slides.partials._delete_modal')
        @endcan

    </div>
@endsection

@section('scripts')
    @include('admin.slides.partials._scripts')
@endsection
