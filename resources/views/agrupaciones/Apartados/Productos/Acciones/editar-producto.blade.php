@extends('layouts.agrupaciones')

@section('title', 'Editar Producto')

@section('content')
    <section class="content sin-padding">
        <form action="{{ route('agrupaciones.productos.update', $producto->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-2 card-success producto-form-full">
                <div class="producto-form-card-header">
                    <h2>Editar producto</h2>
                </div>

                <div class="card-body producto-form-card-body">
                    {{-- Fila 1: Nombre --}}
                    <div class="form-group">
                        <label for="nombre" class="producto-form-label">Nombre del producto <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control"
                            value="{{ old('nombre', $producto->nombre) }}" required>
                    </div>

                    {{-- Fila 2: Descripción --}}
                    <div class="form-group">
                        <label for="descripcion" class="producto-form-label">Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    </div>

                    {{-- Fila 3: Categoría y Precio --}}
                    <div class="row flex-mobile-2">
                        <div class="col-md-6 form-group">
                            <label for="catalogo_id" class="producto-form-label">Categoría <span
                                    class="text-danger">*</span></label>
                            <select name="catalogo_id" id="catalogo_id" class="form-control" required>
                                @foreach ($catalogos as $cat)
                                    <option value="{{ $cat->nombre }}"
                                        {{ old('categoria', $producto->categoria) === $cat->nombre ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('catalogo_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="precio" class="producto-form-label">Precio por Tonelada<span
                                    class="text-danger">*</span></label>
                            <input type="number" name="precio" class="form-control" step="0.01"
                                value="{{ old('precio', $producto->precio) }}" required>
                        </div>
                    </div>

                    {{-- Fila 4: Imagen --}}
                    <div class="form-group">
                        <label for="imagen" class="producto-form-label">Imagen del producto (opcional)</label>
                        <input type="file" name="foto" class="form-control-file" accept="image/*">
                        @error('foto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        @if ($producto->imagen)
                            <div class="mt-2">
                                <img src="{{ $producto->imagen }}" alt="Imagen actual" style="max-width: 200px;">
                                <p class="text-muted">Imagen actual</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('agrupaciones.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Actualizar producto</button>
                </div>
            </div>
        </form>
    </section>
@endsection
