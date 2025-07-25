@extends('layouts.agrupaciones')

@section('title', 'Mis Productos')


@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 font-weight-bold text-success titulo-productos">Mis Productos</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($productos->isEmpty())
                <div class="alert alert-info">
                    Aún no has registrado ningún producto.
                </div>
            @else
                <div class="row">
                    @foreach ($productos as $producto)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 px-0">
                            <div class="card h-100 shadow-sm card-producto">
                                <img src="{{ $producto->imagen }}" class="card-img-top" alt="{{ $producto->nombre }}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $producto->nombre }}</h5>
                                    <p class="card-text mb-1">
                                        <strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}/Tonelada
                                    </p>
                                    <p class="card-text mb-1"><strong>Categoría:</strong> {{ $producto->categoria }}</p>

                                    @php
                                        $estatus = strtolower($producto->estado ?? '');
                                        $icons = [
                                            'pendiente_aprobacion' => 'fas fa-hourglass-half',
                                            'aprobado' => 'fas fa-check-circle',
                                            'rechazado' => 'fas fa-times-circle',
                                        ];
                                        $colores = [
                                            'pendiente_aprobacion' => 'warning',
                                            'aprobado' => 'success',
                                            'rechazado' => 'danger',
                                        ];
                                        $nombresLimpios = [
                                            'pendiente_aprobacion' => 'Pendiente',
                                            'aprobado' => 'Aprobado',
                                            'rechazado' => 'Rechazado',
                                        ];
                                    @endphp

                                    @if (array_key_exists($estatus, $colores))
                                        <span class="badge badge-{{ $colores[$estatus] }} d-block mx-auto mt-2">
                                            <i class="{{ $icons[$estatus] }}"></i>
                                            {{ $nombresLimpios[$estatus] ?? ucfirst($estatus) }}
                                        </span>
                                        <small class="d-block text-muted mt-1 text-center" style="font-size: 0.75rem;">
                                            @switch($estatus)
                                                @case('pendiente_aprobacion')
                                                    Tu producto está en revisión por el administrador.
                                                @break

                                                @case('aprobado')
                                                    Producto visible en el catálogo.
                                                @break

                                                @case('rechazado')
                                                    @if ($producto->motivo_rechazo)
                                                        <div class="text-danger mt-2 text-center">
                                                            <strong>Motivo:</strong> {{ $producto->motivo_rechazo }}
                                                        </div>
                                                    @endif
                                                @break
                                            @endswitch
                                        </small>
                                    @endif
                                </div>
                                <div class="card-footer text-center">
                                    <button type="button"
                                        class="btn-editar-verde btn btn-sm d-inline-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px;"
                                        onclick="window.location.href='{{ route('agrupaciones.productos.edit', $producto->id) }}'">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button
                                        class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px;"
                                        onclick="confirmarEliminacionProducto('{{ route('agrupaciones.productos.destroy', $producto->id) }}', '{{ $producto->nombre }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Botón flotante para crear producto -->
    <a href="{{ route('agrupaciones.productos.create') }}" class="btn-flotante-verde">
        +
    </a>

    @include('agrupaciones.Apartados.Productos.Acciones.eliminar-producto-modal')
@endsection

@section('scripts')
    <script>
        function confirmarEliminacionProducto(url, nombre) {
            $('#nombreProducto').text(nombre);
            $('#formEliminarProducto').attr('action', url);
            $('#modalEliminarProducto').modal('show');
        }
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
