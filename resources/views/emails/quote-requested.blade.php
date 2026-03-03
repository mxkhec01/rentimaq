@extends('emails.layouts.base')

@section('title', 'Nueva Cotización — Rentimaq')
@section('badge', 'Cotización')
@section('heading', 'Nueva Solicitud de Cotización')
@section('subheading', 'Se ha recibido una nueva solicitud de cotización con los siguientes datos:')

@section('cta_url', config('app.url'))
@section('cta_text', 'Ver en Panel')

@section('content')

    {{-- ── Customer Info Section ── --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
        <tr>
            <td style="background-color: #f9fafb; padding: 10px 16px; border-bottom: 1px solid #e5e7eb;">
                <strong style="font-size: 13px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">
                    Datos del Cliente
                </strong>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    @foreach([
                        ['Nombre', $contact->name],
                        ['Empresa', $contact->company ?? 'N/A'],
                        ['Teléfono', $contact->phone ?? 'N/A'],
                        ['Correo', $contact->email ?? 'N/A'],
                        ['Ciudad', $city],
                        ['Dirección de Obra', $address ?: 'N/A'],
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

    {{-- ── Equipment Table ── --}}
    @if(count($items) > 0)
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
            <tr>
                <td style="background-color: #f9fafb; padding: 10px 16px; border-bottom: 1px solid #e5e7eb;">
                    <strong style="font-size: 13px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">
                        Equipos Solicitados
                    </strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 0;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                        {{-- Table Header --}}
                        <tr style="background-color: #1a1a1a;">
                            <td style="padding: 8px 12px; font-size: 11px; color: #ffc107; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Equipo</td>
                            <td style="padding: 8px 12px; font-size: 11px; color: #ffc107; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">Tipo</td>
                            <td style="padding: 8px 12px; font-size: 11px; color: #ffc107; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: center;">Cant.</td>
                            <td style="padding: 8px 12px; font-size: 11px; color: #ffc107; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Detalles</td>
                        </tr>
                        {{-- Table Rows --}}
                        @foreach($items as $i => $item)
                            <tr style="{{ $i % 2 === 0 ? 'background-color: #fff;' : 'background-color: #fafafa;' }}">
                                <td style="padding: 10px 12px; font-size: 13px; color: #1f2937; font-weight: 600; border-bottom: 1px solid #f3f4f6;">
                                    {{ $item['product'] }}
                                </td>
                                <td style="padding: 10px 12px; font-size: 12px; text-align: center; border-bottom: 1px solid #f3f4f6;">
                                    <span style="display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 11px; font-weight: 600; {{ $item['type'] === 'rent' ? 'background-color: #ecfdf5; color: #065f46;' : 'background-color: #eff6ff; color: #1e40af;' }}">
                                        {{ $item['type'] === 'rent' ? 'Renta' : 'Venta' }}
                                    </span>
                                </td>
                                <td style="padding: 10px 12px; font-size: 13px; color: #1f2937; text-align: center; font-weight: 600; border-bottom: 1px solid #f3f4f6;">
                                    {{ $item['quantity'] }}
                                </td>
                                <td style="padding: 10px 12px; font-size: 12px; color: #6b7280; border-bottom: 1px solid #f3f4f6;">
                                    {{ $item['details'] }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    @endif

    {{-- ── Notes ── --}}
    @if($contact->message && str_contains($contact->message, 'Notas:'))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top: 16px;">
            <tr>
                <td style="background-color: #fffbeb; border-left: 3px solid #ffc107; padding: 12px 16px; border-radius: 0 4px 4px 0;">
                    <strong style="font-size: 12px; color: #92400e; text-transform: uppercase;">Notas Adicionales</strong>
                    <p style="margin: 6px 0 0; font-size: 13px; color: #78350f; line-height: 1.5;">
                        {{ Str::after($contact->message, 'Notas: ') }}
                    </p>
                </td>
            </tr>
        </table>
    @endif

@endsection