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
                @if ($infos->isNotEmpty())
                    <div class="row g-3">
                        @foreach ($infos as $info)
                            @include('components.info-card', [
                                'image' => $info->imagen_ruta,
                                'title' => $info->titulo,
                                'text' => $info->texto,
                                'videoId' => $info->video_id,
                                'delay' => $loop->index * 50,
                            ])
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">Aún no hay información publicada.</p>
                @endif

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
        <x-trending-products :products="$trending ?? []" />

        {{-- Para incentivar la compra --}}
        @include('partials.home.cta-promo')

        {{-- Galería de productos --}}
        <x-gallery-products :items="[
            ['img' => 'tomates_galeria.png', 'title' => 'Tomate', 'slug' => '#'],
            ['img' => 'pimiento_galeria.png', 'title' => 'Pimiento', 'slug' => '#'],
            ['img' => 'naranja_galeria.png', 'title' => 'Naranja', 'slug' => '#'],
            ['img' => 'limon_galeria.png', 'title' => 'Limón', 'slug' => '#'],
            ['img' => 'calabaza-galeria.png', 'title' => 'Calabaza', 'slug' => '#'],
            ['img' => 'mandarian_galeria.png', 'title' => 'Mandarina', 'slug' => '#'],
        ]" />

        {{-- Contadores --}}
        @include('partials.home.counters')
    @endsection

    @push('scripts')
        <script src="{{ asset('js/home.js') }}"></script>
    @endpush

    {{-- PONER ESTO AL FINAL DE TU home.blade.php (SOLO TEMPORAL) --}}
<pre>
    {{ file_get_contents(storage_path('logs/laravel.log')) }}
</pre>