{{--
Rentimaq Email Base Layout
Brand: dark header/footer (#1a1a1a), golden accent (#ffc107), white body
Uses inline CSS for maximum email client compatibility (Gmail, Outlook, Yahoo, Apple Mail)
--}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Rentimaq')</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f4f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important;">

    {{-- Outer wrapper --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f7;">
        <tr>
            <td align="center" style="padding: 24px 16px;">

                {{-- Main container: max-width 600px --}}
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="max-width: 600px; width: 100%; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    {{-- ═══════════════════════════════════════════════ --}}
                    {{-- HEADER: Dark with gold accent --}}
                    {{-- ═══════════════════════════════════════════════ --}}
                    <tr>
                        <td style="background-color: #1a1a1a; padding: 28px 32px 20px; text-align: center;">
                            {{-- Brand Name --}}
                            <h1
                                style="margin: 0; font-size: 28px; font-weight: 800; letter-spacing: 3px; color: #ffc107; text-transform: uppercase;">
                                RENTIMAQ
                            </h1>
                            <p
                                style="margin: 6px 0 0; font-size: 11px; color: rgba(255,255,255,0.5); letter-spacing: 1.5px; text-transform: uppercase;">
                                Maquinaria Ligera para Construcción
                            </p>
                        </td>
                    </tr>
                    {{-- Gold accent line --}}
                    <tr>
                        <td
                            style="background: linear-gradient(90deg, #ffc107, #ffca2c, #ffc107); height: 3px; font-size: 0; line-height: 0;">
                            &nbsp;</td>
                    </tr>

                    {{-- ═══════════════════════════════════════════════ --}}
                    {{-- BODY: White content area --}}
                    {{-- ═══════════════════════════════════════════════ --}}
                    <tr>
                        <td style="background-color: #ffffff; padding: 32px;">

                            {{-- Email Type Badge --}}
                            @hasSection('badge')
                                <table role="presentation" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                                    <tr>
                                        <td
                                            style="background-color: #fff8e1; border: 1px solid #ffc107; border-radius: 4px; padding: 6px 14px;">
                                            <span
                                                style="font-size: 11px; font-weight: 700; color: #8b6914; text-transform: uppercase; letter-spacing: 1px;">
                                                @yield('badge')
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            {{-- Main Title --}}
                            <h2 style="margin: 0 0 8px; font-size: 22px; font-weight: 700; color: #1a1a1a;">
                                @yield('heading')
                            </h2>
                            <p style="margin: 0 0 24px; font-size: 14px; color: #6b7280; line-height: 1.5;">
                                @yield('subheading', 'Se ha recibido una nueva solicitud.')
                            </p>

                            {{-- Content sections --}}
                            @yield('content')

                            {{-- CTA Button --}}
                            @hasSection('cta_url')
                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                    style="margin-top: 28px;">
                                    <tr>
                                        <td align="center">
                                            <a href="@yield('cta_url')" target="_blank"
                                                style="display: inline-block; background-color: #ffc107; color: #1a1a1a; font-size: 14px; font-weight: 700; text-decoration: none; padding: 12px 32px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                @yield('cta_text', 'Ver en Panel')
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                        </td>
                    </tr>

                    {{-- ═══════════════════════════════════════════════ --}}
                    {{-- FOOTER: Dark with contact info --}}
                    {{-- ═══════════════════════════════════════════════ --}}
                    <tr>
                        <td style="background-color: #1a1a1a; padding: 24px 32px; text-align: center;">

                            {{-- Company info --}}
                            <p style="margin: 0 0 6px; font-size: 12px; color: rgba(255,255,255,0.7);">
                                <strong style="color: #ffc107;">RENTIMAQ</strong> — Maquinaria Ligera para Construcción
                            </p>
                            <p style="margin: 0 0 4px; font-size: 11px; color: rgba(255,255,255,0.45);">
                                Carretera a Tlacote 184, Col. La Piedad, 76150 — Querétaro, Qro.
                            </p>
                            <p style="margin: 0 0 12px; font-size: 11px; color: rgba(255,255,255,0.45);">
                                Tel: (442) 212 1210 &nbsp;•&nbsp; contacto@rentimaq.com
                            </p>

                            {{-- Divider --}}
                            <table role="presentation" width="80" cellpadding="0" cellspacing="0"
                                style="margin: 0 auto 12px;">
                                <tr>
                                    <td
                                        style="border-top: 1px solid rgba(255,193,7,0.3); font-size: 0; line-height: 0;">
                                        &nbsp;</td>
                                </tr>
                            </table>

                            <p style="margin: 0; font-size: 10px; color: rgba(255,255,255,0.3);">
                                Este correo fue generado automáticamente. Por favor no responda a este mensaje.
                            </p>
                        </td>
                    </tr>

                </table>
                {{-- end main container --}}

            </td>
        </tr>
    </table>

</body>

</html>