@php
    $faviconPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login')</title>
    <link rel="icon" href="{{ asset($faviconPath) }}" type="image/png">

    <!-- Aquí tus estilos: -->
    <link + rel="stylesheet" + href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" +
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" + crossorigin="anonymous" + />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- O Bootstrap CDN, etc. -->
</head>

<body class="layout-auth @yield('body-class')">

    <main class="py-5">
        @yield('content')
    </main>

    <!-- Aquí tus scripts: -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
