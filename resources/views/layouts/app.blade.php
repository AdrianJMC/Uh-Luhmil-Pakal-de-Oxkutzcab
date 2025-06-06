<!DOCTYPE html>
<html lang="es" class="wide wow-animation">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Uh Luhmil Pakal')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

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
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font Awesome para iconos adicionales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha384-DyZ88mC6Up2uqS0h/KRqU6mD3nhN2T6vJhFse5VkPMY5wUKVExlZU5/useYC5HE5" crossorigin="anonymous">

    <!-- ============================
         CSS COMPILADO DE LA APLICACIÓN
    ============================ -->
    <!-- app.css generado por Laravel Mix o tu proceso de build -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- ============================
         CSS EXTRA (SOBREESCRIBIR O AÑADIR)
    ============================ -->
    <!-- style.css para reglas puntuales -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">

    <!-- Css para el diseño de calendarios-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Diseño de pagina registro proveedores-->
    <link rel="stylesheet" href="{{ asset('css/Registro-proveedores-page.css') }}">


    <!-- Mapa con Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


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
    @include('partials.home.footer')


    <!-- ============================
         JS DE TERCEROS
    ============================ -->
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

    @stack('scripts')
</body>

</html>
