@php
    $faviconPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AdminLTE')</title>
    <link rel="icon" href="{{ asset($faviconPath) }}" type="image/png">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons (opcional) -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- Tus estilos personalizados para Admi de agrupaciones -->
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Diseño-Index-Create-Edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Gestion-de-usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Gestion-de-Perfiles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gestor-agrupaciones.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dashboard-agrupaciones/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dashboard-agrupaciones/Page-MisProductos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dashboard-agrupaciones/page-crearProducto.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Dashboard-agrupaciones/page-pedidos.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <style>
        @media (max-width: 768px) {
            body {
                padding-top: 56px;
            }

            .main-header.navbar {
                display: flex !important;
                visibility: visible !important;
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 1040 !important;
            }

            .main-sidebar {
                transform: translateX(-250px) !important;
                /* Oculto por defecto */
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100% !important;
                width: 250px !important;
                background-color: #fff !important;
                z-index: 1050 !important;
                transition: transform 0.3s ease-in-out;
                display: block !important;
                /* 🔥 fuerza visibilidad */
            }

            body.sidebar-open .main-sidebar {
                transform: translateX(0) !important;
                /* Se muestra */
                display: block !important;
                /* 🔥 fuerza visibilidad */
            }

            /* Asegura que el contenido se desactive (efecto overlay) */
            .content-wrapper {
                transition: margin-left 0.3s ease-in-out;
            }
        }
        
    </style>

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('partials.agrupaciones.navbar')

        {{-- Sidebar --}}
        @include('partials.agrupaciones.sidebar')

        {{-- Contenido principal --}}
        <div class="content-wrapper">
            @yield('content')
        </div>

    </div> {{-- /.wrapper --}}
    {{-- /.wrapper --}}

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        // Resuelve conflicto jQuery UI tooltip / Bootstrap tooltip
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob -->
    <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus -->
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- AdminLTE dashboard demo (opcional) -->
    <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>
    <!-- Bootstrap CSS (solo si aún no lo tienes) -->

    <!-- 4) Scripts específicos de cada vista -->
    @yield('scripts')

    @stack('scripts')
</body>

</html>
