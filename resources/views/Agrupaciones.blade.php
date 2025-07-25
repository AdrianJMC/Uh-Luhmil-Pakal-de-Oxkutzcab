@php $mostrarLoader = true; @endphp
@extends('layouts.app')

@section('title', 'Agrupaciones Registradas')

@section('content')
    <div class="container py-5">
        <h2 class="mb-5 text-center fw-bold titulo-movil-ajustado">Agrupaciones Asociadas</h2>

        @if ($agrupaciones->isEmpty())
            <div class="alert alert-info text-center">Aún no hay agrupaciones registradas.</div>
        @else
            <div class="row g-4">
                @foreach ($agrupaciones as $agrupacion)
                    <div class="col-md-6 col-lg-4">
                        <div class="card agrupacion-card h-100 shadow-sm border-0 rounded-3 text-center">
                            <div class="card-body">
                                {{-- Imagen de la hoja --}}
                                <div class="logo-hoja mb-3">
                                    <img src="{{ asset('images/hoja.png') }}" alt="Logo hoja" class="img-hoja">
                                </div>

                                {{-- Nombre agrupación --}}
                                <h5 class="text-dark">
                                    <strong>{{ ucwords(strtolower($agrupacion->nombre_agrupacion)) }}</strong>
                                </h5>

                                {{-- Representante --}}
                                <p class="mb-3"><strong>Representante:</strong><br>{{ $agrupacion->nombre_representante }}
                                </p>

                                {{-- Certificaciones --}}
                                @php
                                    $certificados = explode(',', $agrupacion->certificaciones ?? '');
                                    $certificados = array_filter($certificados);
                                @endphp

                                @if (count($certificados))
                                    <div class="mb-3 text-start">
                                        <strong>Certificaciones:</strong>
                                        <ul class="list-unstyled small mt-2 ms-2">
                                            @foreach (array_slice($certificados, 0, 3) as $cert)
                                                <li>📄 {{ trim($cert) }}</li>
                                            @endforeach

                                            @if (count($certificados) > 3)
                                                <li><a href="#" class="text-decoration-none">Ver más...</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                {{-- Botones --}}
                                <div class="mt-4 d-flex justify-content-center">
                                    <a target="_blank"
                                        href="https://www.google.com/maps/search/?api=1&query={{ urlencode($agrupacion->direccion_agrupacion) }}"
                                        class="btn btn-sm btn-location mr-2">
                                        📍 Ubicación
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación afuera de la grilla --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $agrupaciones->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection


@push('scripts')
<script>
    window.addEventListener('load', function () {
        const loader = document.getElementById('loadingOverlay');
        if (loader) {
            loader.style.display = 'none'; // Ocultar cuando la página terminó de cargar (incluye imágenes)
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('loadingOverlay');

        // Mostrar loader al hacer clic en enlaces internos
        document.querySelectorAll('a[href]:not([target])').forEach(link => {
            link.addEventListener('click', function () {
                const href = this.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('javascript')) {
                    loader.style.display = 'flex';
                }
            });
        });
    });
</script>
@endpush

