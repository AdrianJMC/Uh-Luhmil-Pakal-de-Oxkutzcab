@php
    $logoPath = \App\Models\Setting::getValue('logo', 'images/logo.png');
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación de Registro</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #ffffff; padding: 20px; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

                    {{-- Logo --}}
                    <tr>
                        <td style="padding: 30px; text-align: center;">
                            <img src="{{ $logoPath }}" alt="Logo Uh Luhmil Pakal"
                                 style="max-height: 80px; margin-bottom: 20px;">
                        </td>
                    </tr>

                    {{-- Contenido --}}
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #000;">Hola, {{ $agrupacion->nombre_representante }}</h2>

                            @if ($tipo === 'aprobado')
                                <p style="font-size: 16px; color: #000;">
                                    Tu agrupación <strong>{{ $agrupacion->nombre_agrupacion }}</strong> ha sido <strong
                                        style="color: green;">aprobada</strong>.
                                </p>
                                <p style="font-size: 16px; color: #000;">
                                    Puedes crear tu contraseña en el siguiente enlace:
                                </p>
                                <p style="text-align: center; margin: 30px 0;">
                                    <a href="{{ url('/crear-contraseña?email=' . urlencode($agrupacion->email_representante)) }}"
                                       style="background-color: #198754; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">
                                        Crear contraseña
                                    </a>
                                </p>
                            @else
                                <p style="font-size: 16px; color: #000;">
                                    Lamentamos informarte que tu agrupación
                                    <strong>{{ $agrupacion->nombre_agrupacion }}</strong> fue <strong
                                        style="color: red;">rechazada</strong>.
                                </p>
                                <p style="font-size: 16px; color: #000;">
                                    Si crees que se trata de un error, por favor contáctanos a través del formulario oficial o por medio de nuestro sitio web.
                                </p>
                            @endif

                            <hr style="margin: 30px 0; border: none; border-top: 1px solid #ccc;">

                            <p style="font-size: 14px; color: #000;">
                                Atentamente,<br>
                                <span style="font-style: italic; font-size: 18px;">Equipo de Uh Luhmil Pakal</span>
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 15px; text-align: center; font-size: 12px; color: #666;">
                            Este correo fue enviado automáticamente desde nuestro sistema. Si necesitas asistencia, visita nuestro sitio oficial.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
