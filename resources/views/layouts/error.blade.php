<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Error')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Estilos personalizados --}}
    <style>
        :root {
            --verde: #2f7d32;
            --amarillo: #eda407;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f7f7;
            color: #000;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 40px 20px;
        }

        .error-code {
            font-size: 96px;
            font-weight: 900;
            color: var(--amarillo);
            margin-bottom: 0;
        }

        .error-title {
            color: var(--verde);
            font-size: 32px;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .error-message {
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-back {
            background-color: var(--verde);
            color: white;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: var(--amarillo);
            color: white;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
