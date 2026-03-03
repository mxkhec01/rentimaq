@extends('emails.layouts.base')

@section('title', 'Solicitud de Facturación — Rentimaq')
@section('badge', 'Facturación')
@section('heading', 'Solicitud de Facturación')
@section('subheading', 'Se ha recibido una nueva solicitud de facturación con los siguientes datos:')

@section('cta_url', config('app.url'))
@section('cta_text', 'Ver en Panel')

@section('content')

    {{-- ── Fiscal Data Section ── --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
        <tr>
            <td style="background-color: #f9fafb; padding: 10px 16px; border-bottom: 1px solid #e5e7eb;">
                <strong style="font-size: 13px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">
                    Datos Fiscales
                </strong>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    @foreach([
                        ['Razón Social', $razonSocial],
                        ['RFC', $rfc],
                        ['Email', $email],
                        ['Cuenta de Pago', $cuentaPago],
                    ] as $i => [$label, $value])
                        <tr>
                            <td style="padding: 10px 16px; width: 40%; font-size: 13px; color: #6b7280; border-bottom: 1px solid #f3f4f6; {{ $i % 2 === 0 ? 'background-color: #fafafa;' : '' }}">
                                {{ $label }}
                            </td>
                            <td style="padding: 10px 16px; font-size: 13px; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f3f4f6; {{ $i % 2 === 0 ? 'background-color: #fafafa;' : '' }}">
                                {{ $value }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>

    {{-- ── Address Section ── --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
        <tr>
            <td style="background-color: #f9fafb; padding: 10px 16px; border-bottom: 1px solid #e5e7eb;">
                <strong style="font-size: 13px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">
                    Dirección Fiscal
                </strong>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    @foreach([
                        ['Calle', $calle],
                        ['No. Exterior', $noExterior],
                        ['No. Interior', $noInterior],
                        ['Colonia', $colonia],
                        ['C.P.', $cp],
                        ['Ciudad', $ciudad],
                        ['Municipio', $municipio],
                        ['Estado', $estado],
                        ['País', $pais],
                    ] as $i => [$label, $value])
                        <tr>
                            <td style="padding: 10px 16px; width: 40%; font-size: 13px; color: #6b7280; border-bottom: 1px solid #f3f4f6; {{ $i % 2 === 0 ? 'background-color: #fafafa;' : '' }}">
                                {{ $label }}
                            </td>
                            <td style="padding: 10px 16px; font-size: 13px; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f3f4f6; {{ $i % 2 === 0 ? 'background-color: #fafafa;' : '' }}">
                                {{ $value }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>

@endsection