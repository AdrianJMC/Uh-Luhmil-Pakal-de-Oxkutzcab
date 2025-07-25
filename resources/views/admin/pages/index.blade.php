{{-- resources/views/admin/pages/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Secciones Web')

@section('content')
    <div class="container-fluid">
        {{-- Encabezado con descripción --}}
        <div class="admin-page-header mb-4">
            <h2 class="mb-2">Secciones Web</h2>
        </div>

        @php
            use App\Models\Page;
            $pageHome = $pages?->firstWhere('slug', Page::SLUG_HOME);
            $pageQuienes = $pages?->firstWhere('slug', Page::SLUG_QUIENES);
            $logo = \App\Models\Setting::getValue('logo', 'images/logo.png');
        @endphp

        @if ($pages)
            {{-- Nav tabs --}}
            <ul class="nav nav-tabs mb-3" id="sectionTabs" role="tablist">
                {{-- Logo --}}
                @can('ver_logo')
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-logo" data-bs-toggle="tab" href="#pane-logo" role="tab"
                            aria-controls="pane-logo" aria-selected="true">Logo</a>
                    </li>
                @endcan

                {{-- Página Inicio --}}
                @can('ver_pagina_inicio')
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-inicio" data-bs-toggle="tab" href="#pane-inicio" role="tab"
                            aria-controls="pane-inicio" aria-selected="false">Página Inicio</a>
                    </li>
                @endcan
            </ul>

            {{-- Tab panes --}}
            <div class="tab-content" id="sectionTabsContent">
                {{-- Logo --}}
                @can('ver_logo')
                    <div class="tab-pane fade show active p-3 bg-white border" id="pane-logo" role="tabpanel"
                        aria-labelledby="tab-logo">
                        <div class="d-flex justify-content-between align-items-center" id="logo-pane-header">
                            <h5 class="mb-0">Logo del sitio web</h5>
                            <div class="d-flex align-items-center" id="logo-pane-controls">
                                <img src="{{ $logo }}" width="80" class="me-3 rounded" alt="Logo">
                                <a href="{{ route('admin.settings.logo.edit') }}" class="btn btn-primary btn-sm" role="button">
                                    Cambiar logo
                                </a>
                            </div>
                        </div>
                    </div>
                @endcan

                {{-- Página de Inicio --}}
                @can('ver_pagina_inicio')
                    <div class="tab-pane fade p-3 bg-white border" id="pane-inicio" role="tabpanel"
                        aria-labelledby="tab-inicio">
                        <h5>Secciones de la Página Inicio</h5>
                        <div class="list-group">
                            {{-- 1) Contenido principal --}} 
                            @if ($pageHome)
                                @can('editar_pagina_inicio')
                                <a href="{{ route('admin.pages.edit', $pageHome) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Contenido del Texto "¿Dónde Estamos?”
                                    <span class="badge bg-secondary">Editar</span>
                                </a>
                                @endcan
                            @endif

                            {{-- 2) Información Importante --}}
                            @can('ver_infos')
                            <a href="{{ route('admin.infos.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Subir información o noticias importantes
                                <span class="badge bg-secondary">Administrar</span>
                            </a>
                            @endcan

                            {{-- 3) Slides --}}
                            @can('ver_slides')
                            <a href="{{ route('admin.slides.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Slides del Home
                                <span class="badge bg-secondary">Administrar</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                @endcan
                    
                {{-- Quiénes Somos --}}
                <div class="tab-pane fade p-3 bg-white border" id="pane-quienes" role="tabpanel"
                    aria-labelledby="tab-quienes">
                    <h5>Sección Quiénes Somos</h5>
                    @if ($pageQuienes)
                        <a href="{{ route('admin.pages.edit', $pageQuienes) }}" class="btn btn-secondary btn-sm"
                            role="button">
                            Editar Quiénes Somos
                        </a>
                    @else
                        <div class="alert alert-warning">
                            La página “quienes-somos” aún no existe.
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                No se pudieron cargar las páginas. Intenta nuevamente más tarde.
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/Gestiones-web.js') }}"></script>
@endpush
