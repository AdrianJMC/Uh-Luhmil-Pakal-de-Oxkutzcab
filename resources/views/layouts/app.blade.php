@php
    $faviconPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
@endphp

<!DOCTYPE html>
<html lang="es" class="wide wow-animation">

<style>
    #loadingOverlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Uh Luhmil Pakal')</title>
    <link rel="icon" href="{{ asset($faviconPath) }}" type="image/png">

    <!-- ============================
         CSS DE TERCEROS
    ============================ -->
    <!-- Bootstrap framework -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <!-- Leaflet para mapas interactivos -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- AOS para animaciones al hacer scroll -->
    <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">

    <!-- ============================
         FUENTES E ICONOS
    ============================ -->
    <!-- Tus fuentes personalizadas -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Web/Agrupaciones-asociadas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Web/catalogo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Web/Catalogo-inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Web/Registro-proveedores-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Web/carrito-compras.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">


    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Font Awesome para iconos adicionales -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />



    <!-- ============================
         CSS COMPILADO DE LA APLICACIÓN
    ============================ -->
    <!-- app.css generado por Laravel Mix o tu proceso de build -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- ============================
        CSS PARA TODO LO RELACIONA CON EL HOME
    ============================ -->
    <!-- CSS RELACIONADO CON LA PLANTILLA -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <!-- MIS CSS PROPIOS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    <!-- Mapa con Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="route-cart-add" content="{{ route('cart.add') }}">
    <meta name="route-login" content="{{ route('seleccion.login') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ============================
         ESTILOS PUNTUALES POR VISTA
    ============================ -->
    @stack('styles')
</head>


<body>
    {{-- ============================
         NAVBAR GLOBAL
    ============================ --}}
    @include('partials.home.navbar')

    {{-- ============================
         CONTENIDO PRINCIPAL
    ============================ --}}
    <main>@yield('content')</main>

    {{-- ============================
         FOOTER GLOBAL
    ============================ --}}
    @if (empty($ocultarFooter))
        @include('partials.home.footer')
    @endif

    {{-- Loader --}}
    @if (!empty($mostrarLoader))
        @include('components.loader')
    @endif


    <!-- ============================
         JS DE TERCEROS
    ============================ -->

    <!-- Loader -->
    @if (!empty($mostrarLoader))
        <script src="{{ asset('js/loader.js') }}"></script>
    @endif
    <!-- Leaflet JS para mapas -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- AOS para animaciones -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Inicializa AOS con duración y única ejecución
        AOS.init({
            duration: 600,
            once: true
        });
    </script>

    <!-- ============================
         JS DE LA APLICACIÓN
    ============================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- app.js: tu bundle principal (Vue, Alpine, utilidades, etc.) -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- core.min.js y script.js: librerías adicionales y scripts globales -->
    <script src="{{ asset('js/core.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- ============================
         LAZY-LOAD Y RETINA IMAGENES
    ============================ -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('img').forEach(img => {
                // activa lazy-loading nativo
                img.setAttribute('loading', 'lazy');

                // si el dispositivo tiene DPR >1, intenta cargar @2x
                if (window.devicePixelRatio > 1) {
                    const src = img.getAttribute('src');
                    const ext = src.substring(src.lastIndexOf('.'));
                    const name = src.substring(0, src.lastIndexOf(ext));
                    const retinaUrl = `${name}@2x${ext}`;

                    // comprobación con HEAD antes de asignar srcset
                    fetch(retinaUrl, {
                            method: 'HEAD'
                        })
                        .then(res => {
                            if (res.ok) {
                                img.setAttribute('srcset', `${retinaUrl} 2x`);
                            }
                        })
                        .catch(() => {
                            // si no existe o hay error, no hace nada
                        });
                }
            });
        });
    </script>

    <!-- ============================
         SCRIPTS ESPECÍFICOS POR VISTA
    ============================ -->

    <!--// JS PARA CALENDARIOS-->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- JS PARA GRAFICOS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    @stack('scripts')
</body>

</html>
