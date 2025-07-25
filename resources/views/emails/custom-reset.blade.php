@php
    $logoPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
@endphp


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Restablecer contraseña</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 30px;">
    <table
        style="max-width: 600px; margin: auto; background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
        cellpadding="0" cellspacing="0">
        {{-- Logo --}}
        <tr>
            <td style="padding: 30px; text-align: center;">
                <img src="{{ $logoPath }}" alt="Logo Uh Luhmil Pakal" style="max-height: 80px; margin-bottom: 20px;">
            </td>
        </tr>

        {{-- Título --}}
        <tr>
            <td style="text-align: center; color: #198754;">
                <h2 style="margin: 0;">Uh Luhmil Pakal</h2>
            </td>
        </tr>

        {{-- Mensaje --}}
        <tr>
            <td style="padding: 20px 30px 10px 30px; color: #333;">
                <p>Hola {{ $usuario->name ?? 'usuario' }},</p>
                <p>Recibimos una solicitud para restablecer tu contraseña. Puedes hacerlo haciendo clic en el siguiente
                    botón:</p>
            </td>
        </tr>

        {{-- Botón --}}
        <tr>
            <td style="text-align: center; padding: 20px;">
                <a href="{{ $url }}"
                    style="background-color: #198754; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none;">
                    Restablecer contraseña
                </a>
            </td>
        </tr>

        {{-- Nota --}}
        <tr>
            <td style="padding: 10px 30px 0 30px; color: #333;">
                <p>Si tú no solicitaste esto, simplemente ignora este mensaje.</p>
            </td>
        </tr>

        {{-- Despedida --}}
        <tr>
            <td style="padding: 30px; color: #333;">
                <p style="margin-top: 40px;">Gracias,<br>El equipo de Uh Luhmil Pakal</p>
            </td>
        </tr>
    </table>
</body>

</html>
