@extends('layouts.app')

@section('title', 'Facturación')

@section('content')
    <!-- Floating Hero Section -->
    <div class="position-relative d-flex align-items-center justify-content-center"
        style="min-height: 100vh; background: url('{{ asset('images/invoicing_hero.png') }}') no-repeat center center fixed; background-size: cover; padding-top: 40px; padding-bottom: 40px;">

        <!-- Dark Overlay -->
        <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.5); top:0; left:0;"></div>

        <!-- Form Container -->
        <div class="container position-relative z-index-1 mt-n4">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <!-- Dark Glass Card -->
                    <div class="card shadow-lg border-0 rounded-lg overflow-hidden backdrop-blur-dark" data-aos="fade-up">
                        <div class="card-body p-3 p-lg-4">

                            <!-- Header Inside Card -->
                            <div class="text-center mb-2">
                                <h4 class="font-weight-bold text-uppercase text-white mb-0" style="font-size: 1.5rem;">
                                    Facturación</h4>
                                <p class="small text-warning font-weight-bold letter-spacing-1 mb-0"
                                    style="font-size: 0.7rem;">Solicita tu factura en segundos</p>
                            </div>

                            <form action="{{ route('contact.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="type" value="Facturación">

                                <!-- Fiscal Data Section -->
                                <div class="row">
                                    <div class="col-12 mb-1">
                                        <div class="d-flex align-items-center border-bottom border-secondary pb-1">
                                            <i class="fa fa-id-card-o text-warning mr-2" style="font-size: 0.8rem;"></i>
                                            <h6 class="font-weight-bold text-light text-uppercase mb-0"
                                                style="font-size: 1.5rem;">Datos Fiscales</h6>
                                        </div>
                                    </div>

                                    @foreach ([
                                        ['label' => 'Razón Social', 'name' => 'razon_social', 'placeholder' => 'Nombre de la empresa'],
                                        ['label' => 'RFC', 'name' => 'rfc', 'placeholder' => 'RFC con Homoclave'],
                                        ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'placeholder' => 'correo@ejemplo.com'],
                                        ['label' => 'Cuenta de Pago', 'name' => 'cuenta_pago', 'placeholder' => '1234', 'suffix' => '(4 dígitos)'],
                                    ] as $field)
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="font-weight-bold text-light opacity-60 mb-0" style="font-size: 1rem;">
                                                {{ $field['label'] }}
                                                @isset($field['suffix'])
                                                    <span class="text-muted" style="font-size: 0.65rem;">{{ $field['suffix'] }}</span>
                                                @endisset
                                            </label>
                                            <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}"
                                                class="form-control form-control-sm form-control-dark" required
                                                placeholder="{{ $field['placeholder'] }}">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Address Section -->
                                <div class="row mt-1">
                                    <div class="col-12 mb-1">
                                        <div class="d-flex align-items-center border-bottom border-secondary pb-1">
                                            <i class="fa fa-map-marker text-warning mr-2" style="font-size: 0.8rem;"></i>
                                            <h6 class="font-weight-bold text-light text-uppercase mb-0"
                                                style="font-size: 0.75rem;">Dirección Fiscal</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-5 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">Calle</label>
                                        <input type="text" name="calle"
                                            class="form-control form-control-sm form-control-dark" required>
                                    </div>
                                    <div class="col-md-2 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">No. Ext</label>
                                        <input type="text" name="no_exterior"
                                            class="form-control form-control-sm form-control-dark" required>
                                    </div>
                                    <div class="col-md-2 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">No. Int</label>
                                        <input type="text" name="no_interior"
                                            class="form-control form-control-sm form-control-dark">
                                    </div>
                                    <div class="col-md-3 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">CP</label>
                                        <input type="text" name="cp" class="form-control form-control-sm form-control-dark"
                                            required>
                                    </div>

                                    <div class="col-md-4 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">Colonia</label>
                                        <input type="text" name="colonia"
                                            class="form-control form-control-sm form-control-dark" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">Ciudad</label>
                                        <input type="text" name="ciudad"
                                            class="form-control form-control-sm form-control-dark" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-1">
                                        <label class="font-weight-bold text-light opacity-60 mb-0"
                                            style="font-size: 0.7rem;">Estado</label>
                                        <input type="text" name="estado"
                                            class="form-control form-control-sm form-control-dark" required>
                                    </div>

                                    <!-- Hidden inputs -->
                                    <input type="hidden" name="municipio" value="N/A">
                                    <input type="hidden" name="pais" value="México">
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn btn-warning btn-block py-2 rounded-pill shadow font-weight-bold transform-hover text-dark"
                                        style="font-size: 0.9rem;">
                                        ENVIAR DATOS
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .backdrop-blur-dark {
            background-color: rgba(20, 20, 20, 0.75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .rounded-lg {
            border-radius: 1rem !important;
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        .opacity-60 {
            opacity: 0.6;
        }

        .mt-n4 {
            margin-top: -1.5rem !important;
        }

        /* Ultra Compact Inputs Styling - Improved Visibility */
        .form-control-dark {
            background-color: rgba(0, 0, 0, 0.4) !important;
            /* Darker background for contrast */
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff !important;
            /* Force white text */
            transition: all 0.2s ease;
            font-size: 0.9rem;
            /* Increased slightly from 0.85 for legibility */
            height: calc(1.8em + 0.5rem + 2px);
            padding: 0.25rem 0.5rem;
        }

        .form-control-dark:focus {
            background-color: rgba(0, 0, 0, 0.6) !important;
            border: 1px solid #ffc107;
            color: #fff !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.15);
        }

        /* Autofill override with visible text */
        .form-control-dark:-webkit-autofill,
        .form-control-dark:-webkit-autofill:hover,
        .form-control-dark:-webkit-autofill:focus,
        .form-control-dark:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #222 inset !important;
            /* Dark background match */
            -webkit-text-fill-color: white !important;
        }

        .transform-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 193, 7, 0.3) !important;
        }

        /* More visible placeholder */
        .form-control-dark::placeholder {
            opacity: 0.5;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
@endsection