@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.admin')

@section('title', 'Detalle de Producto')

@section('content')
    @php
        $tab = request('tab', 'pendientes');
    @endphp

    <div class="producto-detail-container">
        <div class="producto-detail-header">
            <h2>Detalles del Producto</h2>
        </div>

        <div class="producto-detail-body">
            {{-- Imagen --}}
            <div class="row mb-4 producto-detail-image-wrap">
                <div class="col-12 text-center">
                    <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="producto-detail-image">
                </div>
            </div>

            {{-- Campos --}}
            <div class="row producto-detail-fields">
                <div class="col-md-6">
                    <label class="producto-detail-label">Agrupación</label>
                    <input type="text" class="producto-detail-field"
                        value="{{ $producto->agrupacion->nombre_agrupacion ?? '-' }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="producto-detail-label">Nombre</label>
                    <input type="text" class="producto-detail-field" value="{{ $producto->nombre }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="producto-detail-label">Categoría</label>
                    <input type="text" class="producto-detail-field" value="{{ $producto->categoria }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="producto-detail-label">
                        Precio (por {{ Str::title($producto->unidad) }})
                    </label>
                    <input type="text" class="producto-detail-field" value="${{ number_format($producto->precio, 2) }}"
                        readonly>
                </div>

                @if (!empty($producto->descripcion))
                    <div class="col-12">
                        <label class="producto-detail-label">Descripción</label>
                        <textarea class="producto-detail-field producto-detail-textarea" rows="3" readonly>{{ $producto->descripcion }}</textarea>
                    </div>
                @endif

                <div class="col-md-6">
                    <label class="producto-detail-label">Estado de aprobación</label>
                    @php
                        $estadoLabel = match ($producto->estado) {
                            'pendiente_aprobacion' => 'Pendiente',
                            'aprobado' => 'Aprobado',
                            'rechazado' => 'Rechazado',
                            default => ucfirst(str_replace('_', ' ', $producto->estado)),
                        };
                    @endphp
                    <input type="text" class="producto-detail-field" value="{{ $estadoLabel }}" readonly>
                </div>
            </div>

            {{-- Botón volver --}}
            <div class="producto-detail-btn-group d-flex justify-content-end mt-4">
                <a href="{{ route('admin.productos.index', ['tab' => $tab]) }}" class="btn producto-detail-back-btn">
                    Volver
                </a>
            </div>
        </div>
    </div>
@endsection
