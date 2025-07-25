@php $mostrarLoader = true; @endphp

{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', $home->title)

@section('content')
    <section class="section section-md bg-light py-5 position-relative section-striped">
        <div class="container">
            <div class="row gx-4 gy-5 align-items-center">

                {{-- Wrapper fijo con tu diseño original --}}
                <div class="col-12 col-md-4">
                    <div class="p-2 bg-black rounded shadow-sm h-100 mt-5 mt-md-0">
                        {{-- Aquí inyectas tu HTML con clases sin escapar --}}
                        {!! $home->content !!}
                    </div>
                </div>

                {{-- La columna del SVG sigue igual --}}
                <div class="col-12 col-md-8 d-flex justify-content-center justify-content-md-end">
                    <div class="p-3 p-md-5 bg-black rounded shadow-sm text-center">
                        <div class="svg-map-container w-100 mw-100 mx-auto">
                            {!! \Illuminate\Support\Facades\File::get(resource_path('svg/mx.svg')) !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- Shape divider hard-coded abajo --}}
        <div class="shape-divider-bottom">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width:100%;height:70px;">
                <path d="M0,0 C600,100 600,100 1200,0 L1200,120 L0,120 Z" fill="#2e7d32" />
            </svg>
        </div>
    </section>

    {{-- Información Importante (dinámica) --}}
    <section class="section section-md pt-0 mt-0 mt-md-0">
        <div class="container">
            <h2 class="p-4 h2 text-center mb-4">Información importante</h2>
            <div class="row g-3">
                @forelse ($infos as $info)
                    @include('components.info-card', [
                        'image' => $info->imagen_ruta,
                        'title' => $info->titulo,
                        'text' => $info->texto,
                        'videoId' => $info->video_id,
                        'delay' => $loop->index * 50,
                    ])
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            De momento no hay información importante disponible.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    {{-- Lightbox Vídeo --}}
    <div id="videoLightbox">
        <div class="video-backdrop"></div>
        <div class="video-container">
            <button id="closeVideo" aria-label="Cerrar vídeo">&times;</button>
            <div class="ratio ratio-16x9">
                <iframe id="lightboxIframe" src="" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>

    {{-- Slider principal --}}
    @include('partials.home.slider-bar-home')

    {{-- Productos en tendencia --}}
    <x-trending-products :randomCount="4" :products="App\Models\Producto::where('estado', 'aprobado')->inRandomOrder()->take(4)->get()" />

    {{-- Para incentivar la compra --}}
    @include('partials.home.cta-promo')


    {{-- Galería de productos --}}
    <x-gallery-products :items="$catalogos" title="Catálogos Disponibles" />

    {{-- Modal agrupaciones --}}
    <div class="modals-container">
        @include('partials.home.modals.Show-agrupaciones-catalogo')
        <!-- Otros modales -->
    </div>

    {{-- Contadores --}}
    <section class="counters-section">
        @include('partials.home.counters')
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>
@endpush
