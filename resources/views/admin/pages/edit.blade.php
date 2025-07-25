{{-- resources/views/admin/pages/edit.blade.php --}}
@php
    $puedeEditar = false;

    if ($page->slug === 'home' && auth()->user()->can('editar_pagina_inicio')) {
        $puedeEditar = true;
    } elseif ($page->slug === 'quienes-somos' && auth()->user()->can('editar_pagina_quienes')) {
        $puedeEditar = true;
    } elseif ($page->slug === 'informacion-importante' && auth()->user()->can('editar_infos')) {
        $puedeEditar = true;
    }
@endphp

@if (! $puedeEditar)
    <div class="alert alert-danger">
        No tienes permisos para editar esta sección.
    </div>
    @php exit; @endphp
@endif


@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        {{-- Cabecera --}}
        @if ($page->slug !== 'home')
            <div class="page-header mb-4">
                <h2 class="page-title">Editar sección: <code>{{ $page->slug }}</code></h2>
            </div>
        @endif


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Card principal alrededor del formulario --}}
        <div class="card page-content-card">
            <div class="card-body">
                <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-4">
                        <label for="title" class="form-label form-label-highlight">Título</label>
                        <input type="text" id="title" name="title"
                            class="form-control form-control-custom @error('title') is-invalid @enderror"
                            value="{{ old('title', $page->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contenido (TinyMCE) --}}
                    <div class="mb-4">
                        <label for="content" class="form-label form-label-highlight">Contenido (HTML con clases)</label>
                        <textarea id="content" name="content" class="form-control form-control-custom @error('content') is-invalid @enderror"
                            rows="10">{{ old('content', $page->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Imágenes (si NO es home) --}}
                    @if ($page->slug !== 'home')
                        <div class="mb-4 image-section">
                            <label class="form-label form-label-highlight">Imagen actual</label><br>
                            @if ($page->image)
                                <img src="{{ asset('storage/' . $page->image) }}" alt="Imagen actual"
                                    class="img-preview mb-2">
                            @else
                                <span class="text-muted">— Sin imagen —</span><br>
                            @endif

                            <label for="image" class="form-label mt-3">Subir nueva imagen (opcional)</label>
                            <input type="file" id="image" name="image"
                                class="form-control form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    {{-- Campos para “informacion-importante” --}}
                    @if ($page->slug === 'informacion-importante')
                        {{-- Imagen principal --}}
                        <div class="mb-4 image-section">
                            <label class="form-label form-label-highlight">Imagen principal</label><br>
                            @if ($page->image)
                                <img src="{{ asset('storage/' . $page->image) }}" alt="Imagen principal"
                                    class="img-preview mb-2">
                            @endif
                            <input type="file" name="image" class="form-control form-control-file">
                        </div>

                        {{-- Imagen secundaria --}}
                        <div class="mb-4 image-section">
                            <label class="form-label form-label-highlight">Imagen secundaria</label><br>
                            @if ($page->image2)
                                <img src="{{ asset('storage/' . $page->image2) }}" alt="Imagen secundaria"
                                    class="img-preview mb-2">
                            @endif
                            <input type="file" name="image2" class="form-control form-control-file">
                        </div>

                        {{-- Imagen adicional --}}
                        <div class="mb-4 image-section">
                            <label class="form-label form-label-highlight">Imagen adicional</label><br>
                            @if ($page->image3)
                                <img src="{{ asset('storage/' . $page->image3) }}" alt="Imagen adicional"
                                    class="img-preview mb-2">
                            @endif
                            <input type="file" name="image3" class="form-control form-control-file">
                        </div>

                        {{-- Vídeo --}}
                        <div class="mb-4">
                            <label for="video_url" class="form-label form-label-highlight">URL Vídeo (YouTube,
                                Vimeo…)</label>
                            <input type="text" name="video_url" id="video_url"
                                class="form-control form-control-custom @error('video_url') is-invalid @enderror"
                                value="{{ old('video_url', $page->video_url) }}">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-warning me-2">Guardar cambios</button>
                        <a href="{{ route('admin.pages.index') }}#pane-inicio" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/Gestiones-web.js') }}"></script>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'code lists link',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | code',
            menubar: false,
            valid_elements: '*[*]',
            extended_valid_elements: 'div[class],h2[class],p[class],ul[class],li[class],i[class],strong,em,svg[*],path[*]',
            forced_root_block: false,
            content_css: false
        });
    </script>
@endpush
