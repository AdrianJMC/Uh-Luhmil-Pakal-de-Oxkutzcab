@extends('layouts.admin')

@cannot('ver_infos')
    <div class="alert alert-danger p-4">
        No tienes permiso para ver esta sección.
    </div>
    @php exit; @endphp
@endcannot

@section('content')
    <div class="container-fluid py-4 position-relative">
        {{-- Título con contador y botón de volver --}}
        <h2 class="section-title mb-4">
            <a href="{{ route('admin.pages.index') }}#pane-inicio" class="back-circle" title="Volver a Secciones Web">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                    class="bi bi-arrow-left back-arrow-icon" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5
                                                                                                0 1 0-.708-.708l-4 4a.5.5
                                                                                                0 0 0 0 .708l4 4a.5.5
                                                                                                0 0 0 .708-.708L2.707
                                                                                                8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
            </a>
            Información Importante
            <span class="badge bg-warning text-white">{{ $infos->count() }}</span>

            @if ($infos->count() >= 4)
                <span id="slide-limit-alert" class="badge-slide-limit">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Máximo 4 infos
                </span>
            @endif
        </h2>

        @if (session('error'))
            <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif


        {{-- Tabla de infos --}}
        <div class="card page-list-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Título de la info</th>
                                <th>Detalles</th>
                                <th class="text-center">Imagen</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($infos as $info)
                                <tr>
                                    @if ($info->is_video)
                                        {{-- Es video: muestra solo texto en todas las columnas relevantes --}}
                                        <td class="text-center align-middle" colspan="2">
                                            Este contenido es un <strong>video</strong>
                                        </td>
                                        <td class="text-center align-middle">
                                            <img src="{{ $info->imagen_ruta }}" alt="Miniatura del video"
                                                class="info-table-img rounded">
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button class="btn btn-sm btn-edit" data-toggle="modal"
                                                    data-target="#modalEditarInfo-{{ $info->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn btn-sm btn-delete" data-toggle="modal"
                                                    data-target="#modalEliminar-video-{{ $info->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @else
                                        {{-- Es info normal: texto, imagen, etc --}}
                                        <td class="align-middle">{{ $info->titulo }}</td>
                                        <td class="align-middle">{{ \Illuminate\Support\Str::limit($info->texto, 60) }}</td>
                                        <td class="text-center align-middle">
                                            <img src="{{ $info->imagen_ruta }}" alt="Imagen de la info"
                                                class="info-table-img rounded">
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                @can('editar_infos')
                                                    <button class="btn btn-sm btn-edit" data-toggle="modal"
                                                        data-target="#modalEditarInfo-{{ $info->id }}"><i
                                                            class="fas fa-pencil-alt"></i>
                                                    </button>
                                                @endcan

                                                @can('eliminar_infos')
                                                    <button class="btn btn-sm btn-delete" data-toggle="modal"
                                                        data-target="#modalEliminarInfo-{{ $info->id }}"><i
                                                            class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Botón para crear nueva info --}}
        @can('crear_infos')
            @if ($infos->count() < 4)
                <button class="btn btn-create-plus" data-toggle="modal" data-target="#modalCrearInfo" title="Nueva info">
                    +
                </button>
            @endif
        @endcan

        {{-- Modales --}}
        @can('crear_infos')
            @include('admin.infos.partials._create_modal')
        @endcan


        @foreach ($infos as $info)
            @can('editar_infos')
                @include('admin.infos.partials._edit_modal', ['info' => $info])
            @endcan
        @endforeach

        @foreach ($infos as $info)
            @can('eliminar_infos')
                @if ($info->is_video)
                    @include('admin.infos.partials._delete_modal_infos', ['info' => $info])
                @else
                    @include('admin.infos.partials._delete_modal', ['info' => $info])
                @endif
            @endcan
        @endforeach

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const $alert = $('#error-alert, #success-alert');
            if ($alert.length) {
                setTimeout(() => {
                    $alert.alert('close');
                }, 5000); // ⏱️ 5 segundos
            }
        });
    </script>
@endsection
