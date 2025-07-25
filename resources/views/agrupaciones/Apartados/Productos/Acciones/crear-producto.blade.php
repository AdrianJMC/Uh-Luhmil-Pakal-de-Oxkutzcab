@extends('layouts.agrupaciones')

@section('title', 'Nuevo Producto')

@section('content')
    <section class="content sin-padding">
        <form action="{{ route('agrupaciones.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card card-success producto-form-full">
                <div class="producto-form-card-header">
                    <h2>Registrar nuevo producto</h2>
                </div>

                <div class="card-body producto-form-card-body">
                    {{-- Fila 1: Nombre (ocupa todo el ancho) --}}
                    <div class="form-group">
                        <label for="nombre" class="producto-form-label">Nombre del producto <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    {{-- Fila 2: Descripción (ocupa todo el ancho) --}}
                    <div class="form-group">
                        <label for="descripcion" class="producto-form-label">Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-control"></textarea>
                    </div>

                    {{-- Fila 3: Categoría y Unidad --}}
                    <div class="row flex-mobile-2">
                        <div class="col-md-6 form-group">
                            <label for="catalogo_id" class="producto-form-label">
                                Categoria <span class="text-danger">*</span>
                            </label>
                            <select name="catalogo_id" id="catalogo_id" class="form-control" required>
                                <option value="">-- Selecciona una categoria --</option>
                                @foreach ($catalogos as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="precio" class="producto-form-label">Precio por Tonelada ($ MXN) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="precio" class="form-control" step="0.01" required>
                        </div>
                    </div>

                    {{-- Fila 5: Imagen (ocupa todo el ancho) --}}
                    <div class="form-group">
                        <label for="imagen" class="producto-form-label">Imagen del producto <span
                                class="text-danger">*</span></label>
                        <input type="file" name="foto" class="form-control-file" accept="image/*" required>
                        @error('foto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Corrige los siguientes errores:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-footer text-right">
                    <a href="{{ route('agrupaciones.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Crear producto</button>
                </div>
            </div>
        </form>
    </section>
@endsection
