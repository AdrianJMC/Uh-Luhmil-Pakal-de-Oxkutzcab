<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login')</title>
    <link rel="icon" href="{{ secure_asset('images/logo.png') }}" type="image/png">

    <!-- Aquí tus estilos: -->
    <link + rel="stylesheet" + href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" +
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" + crossorigin="anonymous" + />
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('css/auth.css') }}" rel="stylesheet">
    <!-- O Bootstrap CDN, etc. -->
</head>

<body class="d-flex align-items-center justify-content-center"
    style="min-height:100vh; font-family:'Source Sans 3',sans-serif;">


    <main class="py-5">
        @yield('content')
    </main>

    <!-- Aquí tus scripts: -->
    <script src="{{ secure_asset('js/app.js') }}"></script>

    @stack('scripts')

</body>

</html>
