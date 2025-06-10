<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AdminLTE')</title>
    <link rel="icon" href="@assetAuto('images/logo.png')" type="image/png">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="@assetAuto('adminlte/plugins/fontawesome-free/css/all.min.css')">
    <!-- Ionicons (opcional) -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus -->
    <link rel="stylesheet"
        href="@assetAuto('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')">
    <!-- iCheck -->
    <link rel="stylesheet" href="@assetAuto('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')">
    <!-- JQVMap -->
    <link rel="stylesheet" href="@assetAuto('adminlte/plugins/jqvmap/jqvmap.min.css')">
    <!-- Theme style -->
    <link rel="stylesheet" href="@assetAuto('adminlte/dist/css/adminlte.min.css')">

    <!-- Tus estilos personalizados para Admin -->
    <link rel="stylesheet" href="@assetAuto('css/admin-custom.css')">
    <link rel="stylesheet" href="@assetAuto('css/Diseño-Index-Create-Edit.css')">
    <link rel="stylesheet" href="@assetAuto('css/Gestion-de-usuarios.css')">


    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="@assetAuto('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="@assetAuto('adminlte/plugins/daterangepicker/daterangepicker.css')">
    <!-- Summernote -->
    <link rel="stylesheet" href="@assetAuto('adminlte/plugins/summernote/summernote-bs4.min.css')">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('partials.Admin.navbar')

        {{-- Sidebar --}}
        @include('partials.Admin.sidebar')

        {{-- Contenido principal --}}
        <div class="content-wrapper">
            @yield('content')
        </div>
        {{-- /.content-wrapper --}}

    </div>
    {{-- /.wrapper --}}

    <!-- jQuery -->
    <script src="@assetAuto('adminlte/plugins/jquery/jquery.min.js')"></script>
    <!-- jQuery UI -->
    <script src="@assetAuto('adminlte/plugins/jquery-ui/jquery-ui.min.js')"></script>
    <script>
        // Resuelve conflicto jQuery UI tooltip / Bootstrap tooltip
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="@assetAuto('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')"></script>
    <!-- ChartJS -->
    <script src="@assetAuto('adminlte/plugins/chart.js/Chart.min.js')"></script>
    <!-- Sparkline -->
    <script src="@assetAuto('adminlte/plugins/sparklines/sparkline.js')"></script>
    <!-- JQVMap -->
    <script src="@assetAuto('adminlte/plugins/jqvmap/jquery.vmap.min.js')"></script>
    <script src="@assetAuto('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')"></script>
    <!-- jQuery Knob -->
    <script src="@assetAuto('adminlte/plugins/jquery-knob/jquery.knob.min.js')"></script>
    <!-- daterangepicker -->
    <script src="@assetAuto('adminlte/plugins/moment/moment.min.js')"></script>
    <script src="@assetAuto('adminlte/plugins/daterangepicker/daterangepicker.js')"></script>
    <!-- Tempusdominus -->
    <script src="@assetAuto('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')"></script>
    <!-- Summernote -->
    <script src="@assetAuto('adminlte/plugins/summernote/summernote-bs4.min.js')"></script>
    <!-- overlayScrollbars -->
    <script src="@assetAuto('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')"></script>
    <!-- AdminLTE App -->
    <script src="@assetAuto('adminlte/dist/js/adminlte.min.js')"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="@assetAuto('adminlte/dist/js/demo.js')"></script>
    <!-- AdminLTE dashboard demo (opcional) -->
    <script src="@assetAuto('adminlte/dist/js/pages/dashboard.js')"></script>
    <!-- Bootstrap CSS (solo si aún no lo tienes) -->

    <!-- 4) Scripts específicos de cada vista -->
    @yield('scripts')

    @stack('scripts')
</body>

</html>
