@extends('emails.layouts.base')

@section('title', 'Nuevo Contacto — Rentimaq')
@section('badge', 'Contacto')
@section('heading', 'Nuevo Mensaje de Contacto')
@section('subheading', 'Se ha recibido un nuevo mensaje desde el formulario de contacto:')

@section('cta_url', config('app.url'))
@section('cta_text', 'Ver en Panel')

@section('content')

    {{-- ── Contact Info Section ── --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
        <tr>
            <td style="background-color: #f9fafb; padding: 10px 16px; border-bottom: 1px solid #e5e7eb;">
                <strong style="font-size: 13px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">
                    Datos del Remitente
                </strong>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    @foreach([
                        ['Nombre', $contact->name],
                        ['Empresa', $contact->company ?? 'N/A'],
                        ['Correo', $contact->email ?? 'N/A'],
                        ['Teléfono', $contact->phone ?? 'N/A'],
                    ] as $i => [$label, $value])
                        <tr>
                            <td style="padding: 10px 16px; width: 35%; font-size: 13px; color: #6b7280; border-bottom: 1px solid #f3f4f6; {{ $i % 2 === 0 ? 'background-color: #fafafa;' : '' }}">
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

    {{-- ── Subject ── --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 16px;">
        <tr>
            <td style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 14px 16px;">
                <strong style="font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Asunto</strong>
                <p style="margin: 6px 0 0; font-size: 15px; color: #1f2937; font-weight: 600;">
                    {{ $asunto }}
                </p>
            </td>
        </tr>
    </table>

    {{-- ── Message Body ── --}}
    @if($mensaje)
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="background-color: #fffbeb; border-left: 3px solid #ffc107; padding: 14px 16px; border-radius: 0 4px 4px 0;">
                    <strong style="font-size: 12px; color: #92400e; text-transform: uppercase;">Mensaje</strong>
                    <p style="margin: 8px 0 0; font-size: 14px; color: #78350f; line-height: 1.6; white-space: pre-wrap;">{{ $mensaje }}</p>
                </td>
            </tr>
        </table>
    @endif

@endsection