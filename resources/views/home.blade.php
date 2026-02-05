@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <div class="position-relative d-flex align-items-center text-white"
        style="min-height: 85vh; background: url('{{ asset('images/home_hero.png') }}') no-repeat center center; background-size: cover;">
        <div class="position-absolute w-100 h-100"
            style="background: linear-gradient(to right, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 100%); top:0; left:0;"></div>

        <div class="container position-relative z-index-1">
            <div class="row">
                <div class="col-lg-7" data-aos="fade-right">
                    <span class="badge badge-warning text-uppercase px-3 py-2 mb-4 font-weight-bold"
                        style="letter-spacing: 2px;">Líderes en el Bajío</span>
                    <h1 class="display-3 font-weight-bold mb-4 line-height-1 text-white">Tu Obra No Puede Detenerse.</h1>
                    <p class="lead mb-5 opacity-80" style="font-size: 1.4rem; color: rgba(255,255,255,0.85);">Renta y venta
                        de maquinaria ligera
                        con los precios más competitivos y las mejores marcas del mercado.</p>

                    <div class="d-flex flex-wrap">
                        <a href="{{ route('rentals.index') }}"
                            class="btn btn-warning btn-lg px-5 py-3 mr-3 mb-3 font-weight-bold rounded-pill shadow-lg transform-hover text-dark">Ver
                            Catálogo</a>
                        <a href="{{ route('quote') }}"
                            class="btn btn-outline-light btn-lg px-5 py-3 mb-3 font-weight-bold rounded-pill transform-hover">Solicitar
                            Cotización</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-5" style="background: transparent;">
        <div class="container py-5">
            <div class="row text-center">
                <div class="col-12 mb-5">
                    <h2 class="font-weight-bold display-5 text-white">¿Por qué elegir Rentimaq?</h2>
                    <div style="width: 60px; height: 4px; background: #ffc107; margin: 15px auto;"></div>
                </div>

                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card glass-card p-4 h-100 rounded-lg">
                        <div class="icon-circle bg-dark-glass text-warning mb-4 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fa fa-tag fa-2x"></i>
                        </div>
                        <h4 class="font-weight-bold text-white">Precios Bajos</h4>
                        <p class="text-light-50">Garantizamos costos competitivos para maximizar tu presupuesto de obra.</p>
                    </div>
                </div>

                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card glass-card p-4 h-100 rounded-lg">
                        <div class="icon-circle bg-dark-glass text-warning mb-4 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fa fa-star fa-2x"></i>
                        </div>
                        <h4 class="font-weight-bold text-white">Mejores Marcas</h4>
                        <p class="text-light-50">Equipos Honda, Makita, Stihl y más. Solo maquinaria confiable.</p>
                    </div>
                </div>

                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card glass-card p-4 h-100 rounded-lg">
                        <div class="icon-circle bg-dark-glass text-warning mb-4 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fa fa-clock-o fa-2x"></i>
                        </div>
                        <h4 class="font-weight-bold text-white">Renta Ágil</h4>
                        <p class="text-light-50">Proceso simplificado. Entrega rápida en tu obra sin complicaciones.</p>
                    </div>
                </div>

                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card glass-card p-4 h-100 rounded-lg">
                        <div class="icon-circle bg-dark-glass text-warning mb-4 mx-auto d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px; border-radius: 50%;">
                            <i class="fa fa-users fa-2x"></i>
                        </div>
                        <h4 class="font-weight-bold text-white">Atención Personal</h4>
                        <p class="text-light-50">Asesoría experta para elegir el equipo correcto para tu trabajo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Strip -->
    <div class="bg-warning py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 text-center text-lg-left mb-4 mb-lg-0">
                    <h2 class="font-weight-bold text-dark mb-2">¿Listo para empezar tu proyecto?</h2>
                    <p class="h5 text-dark mb-0">Contáctanos hoy mismo vía WhatsApp para una respuesta inmediata.</p>
                </div>
                <div class="col-lg-4 text-center text-lg-right">
                    <a href="https://api.whatsapp.com/send?phone=5214424754724" target="_blank"
                        class="btn btn-dark btn-lg rounded-pill px-5 shadow-lg transform-hover">
                        <i class="fa fa-whatsapp mr-2"></i> Enviar Mensaje
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-height-1 {
            line-height: 1.1;
        }

        .transform-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 193, 7, 0.2) !important;
        }

        .icon-circle {
            transition: all 0.3s;
        }

        .feature-card:hover .icon-circle {
            background-color: #ffc107 !important;
            color: #212529 !important;
            transform: scale(1.1);
        }

        /* Glass Card Styles */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 193, 7, 0.3);
            transform: translateY(-5px);
        }

        .bg-dark-glass {
            background: rgba(0, 0, 0, 0.3);
        }

        .text-light-50 {
            color: rgba(255, 255, 255, 0.6);
        }

        .rounded-lg {
            border-radius: 1rem !important;
        }
    </style>
@endsection