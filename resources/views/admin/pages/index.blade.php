{{-- resources/views/admin/pages/index.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- Encabezado con descripción --}}
        <div class="admin-page-header mb-4">
            <h2 class="mb-2">Secciones Web</h2>
        </div>

        @php
            $pageHome = $pages->firstWhere('slug', 'home');
            $pageQuienes = $pages->firstWhere('slug', 'quienes-somos');
            $logo = \App\Models\Setting::getValue('logo', 'images/logo.png');
        @endphp

        {{-- Nav tabs --}}
        <ul class="nav nav-tabs mb-3" id="sectionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="tab-logo" data-bs-toggle="tab" href="#pane-logo" role="tab"
                    aria-controls="pane-logo" aria-selected="true">Logo</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-inicio" data-bs-toggle="tab" href="#pane-inicio" role="tab"
                    aria-controls="pane-inicio" aria-selected="false">Página Inicio</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tab-quienes" data-bs-toggle="tab" href="#pane-quienes" role="tab"
                    aria-controls="pane-quienes" aria-selected="false">Quiénes Somos</a>
            </li>
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content" id="sectionTabsContent">
            {{-- Logo --}}
            <div class="tab-pane fade show active p-3 bg-white border" id="pane-logo" role="tabpanel"
                aria-labelledby="tab-logo">
                <div class="d-flex justify-content-between align-items-center" id="logo-pane-header">
                    <h5 class="mb-0">Logo del sitio web</h5>
                    <div class="d-flex align-items-center" id="logo-pane-controls">
                        <img src="{{ asset('storage/' . $logo) }}" width="80" class="me-3 rounded" alt="Logo">
                        <a href="{{ route('admin.settings.logo.edit') }}" class="btn btn-primary btn-sm">
                            Cambiar logo
                        </a>
                    </div>
                </div>
            </div>

            {{-- Página de Inicio --}}
            <div class="tab-pane fade p-3 bg-white border" id="pane-inicio" role="tabpanel" aria-labelledby="tab-inicio">
                <h5>Secciones de la Página Inicio</h5>
                <div class="list-group">
                    {{-- 1) Contenido principal --}}
                    <a href="{{ route('admin.pages.edit', $pageHome) }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Contenido del Texto "¿Donde Estamos?”
                        <span class="badge bg-secondary">Editar</span>
                    </a>

                    {{-- 2) Información Importante --}}
                    <a href="{{ route('admin.infos.index') }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Subir informacion o noticias importantes
                        <span class="badge bg-secondary">Administrar</span>
                    </a>

                    {{-- 3) Slides --}}
                    <a href="{{ route('admin.slides.index') }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Slides del Home
                        <span class="badge bg-secondary">Administrar</span>
                    </a>
                </div>
            </div>

            {{-- Quiénes Somos --}}
            <div class="tab-pane fade p-3 bg-white border" id="pane-quienes" role="tabpanel" aria-labelledby="tab-quienes">
                <h5>Sección Quiénes Somos</h5>
                @if ($pageQuienes)
                    <a href="{{ route('admin.pages.edit', $pageQuienes) }}" class="btn btn-secondary btn-sm">
                        Editar Quiénes Somos
                    </a>
                @else
                    <div class="alert alert-warning">
                        La página “quienes-somos” aún no existe.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1) Inicializar manualmente los tabs de Bootstrap
            document.querySelectorAll('#sectionTabs a[data-bs-toggle="tab"]').forEach(tabEl => {
                const tab = new bootstrap.Tab(tabEl)
                tabEl.addEventListener('click', e => {
                    e.preventDefault()
                    tab.show()
                })
            })

            // 2) Si existe un hash en la URL, mostramos ese tab al cargar
            const hash = window.location.hash
            if (hash) {
                // Buscamos el <a> cuyo href termine en ese hash
                const targetLink = document.querySelector(`#sectionTabs a[href="${hash}"]`)
                if (targetLink) {
                    // Forzamos que Bootstrap muestre ese tab
                    new bootstrap.Tab(targetLink).show()
                }
            }
        })
    </script>
@endpush

