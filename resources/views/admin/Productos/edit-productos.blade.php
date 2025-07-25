@php
    $tab = request('tab', 'aprobados');
@endphp

@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
    @php
        $tab = request('tab', 'pendientes');
    @endphp

    <div class="producto-detail-container">
        <div class="producto-detail-header">
            <h2>Editar Producto</h2>
        </div>

        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="producto-detail-body">
                {{-- Imagen actual + upload --}}
                <div class="row mb-4 producto-detail-image-wrap">
                    <div class="col-6 text-center">
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" class="producto-detail-image">
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <div class="w-100">
                            <label class="producto-detail-label">Cambiar imagen</label>
                            <input type="file" name="imagen" class="producto-detail-field">
                        </div>
                    </div>
                </div>

                <div class="row producto-detail-fields">
                    <div class="col-md-6">
                        <label class="producto-detail-label">Agrupación</label>
                        <select name="agrupacion_id" class="producto-detail-field">
                            <option value="">— sin agrupación —</option>
                            @foreach ($agrupaciones as $agr)
                                <option value="{{ $agr->id }}" @if ($producto->agrupacion_id == $agr->id) selected @endif>
                                    {{ $agr->nombre_agrupacion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="producto-detail-label">Nombre</label>
                        <input type="text" name="nombre" class="producto-detail-field"
                            value="{{ old('nombre', $producto->nombre) }}">
                    </div>

                    {{-- Categoría --}}
                    <div class="col-md-6">
                        <label class="producto-detail-label">Categoría <span class="text-danger">*</span></label>
                        <select name="categoria" class="producto-detail-field" required>
                            <option value="">— Selecciona una categoría —</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('categoria', $producto->categoria) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="producto-detail-label">
                            Precio (por {{ Str::title($producto->unidad) }})
                        </label>
                        <input type="number" step="0.01" name="precio" class="producto-detail-field"
                            value="{{ old('precio', $producto->precio) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="producto-detail-label">Stock</label>
                        <input type="number" name="stock" class="producto-detail-field"
                            value="{{ old('stock', $producto->stock) }}">
                    </div>

                    {{-- Unidad --}}
                    <div class="col-md-6">
                        <label class="producto-detail-label">Unidad de medida <span class="text-danger">*</span></label>
                        <select name="unidad" class="producto-detail-field" required>
                            <option value="">— Selecciona unidad —</option>
                            @foreach ($unidades as $u)
                                <option value="{{ $u }}"
                                    {{ old('unidad', $producto->unidad) === $u ? 'selected' : '' }}>
                                    {{ $u }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="producto-detail-label">Descripción</label>
                        <textarea name="descripcion" class="producto-detail-field producto-detail-textarea" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="producto-detail-label">Estado de aprobación</label>

                        {{-- Hidden para que el controlador reciba el estado actual --}}
                        <input type="hidden" name="estado" value="{{ $producto->estado }}">

                        {{-- Solo‐lectura para que el usuario lo vea pero no lo cambie --}}
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

                {{-- Botones --}}
                <div class="producto-detail-btn-group d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.productos.index', ['tab' => $tab]) }}" class="btn btn-secondary ml-3">
                        Cancelar
                    </a>
                    <button type="submit" class="btn producto-detail-save-btn">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
