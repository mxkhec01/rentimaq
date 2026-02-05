@extends('layouts.app')

@section('title', 'Nosotros')

@section('content')
    <!-- Hero Section -->
    <div class="position-relative d-flex align-items-center justify-content-center text-center text-white"
        style="min-height: 60vh; background: url('{{ asset('images/construction_hero.png') }}') no-repeat center center; background-size: cover;">
        <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.7); top:0; left:0;"></div>
        <div class="position-relative container" data-aos="fade-up">
            <h1 class="display-3 font-weight-bold text-uppercase" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                Construyendo el Futuro</h1>
            <p class="lead mb-0 font-weight-bold text-warning" style="letter-spacing: 3px; font-size: 1.5rem;">CALIDAD •
                POTENCIA • CONFIANZA</p>
            <div style="width: 80px; height: 5px; background: #ffc107; margin: 20px auto;"></div>
        </div>
    </div>

    <!-- Values Grid -->
    <div class="container py-5" style="margin-top: -50px; position: relative; z-index: 10;">
        <div class="row text-center">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="p-5 glass-card shadow-lg h-100 rounded-lg transform-hover"
                    style="border-bottom: 3px solid #ffc107;">
                    <div class="mb-4 text-warning"><i class="fa fa-handshake-o fa-4x"></i></div>
                    <h4 class="font-weight-bold mb-3 text-white">Confianza Total</h4>
                    <p class="text-light-50 mb-0">Forjamos relaciones duraderas basadas en la honestidad, transparencia y el
                        cumplimiento de cada promesa.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-5 glass-card shadow-lg h-100 rounded-lg transform-hover"
                    style="border-bottom: 3px solid #28a745;">
                    <div class="mb-4 text-success"><i class="fa fa-cogs fa-4x"></i></div>
                    <h4 class="font-weight-bold mb-3 text-white">Maquinaria Premium</h4>
                    <p class="text-light-50 mb-0">Flota moderna y en perfecto estado. Equipos de marcas líderes con
                        mantenimiento riguroso para tu obra.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-4 col-md-12 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="p-5 glass-card shadow-lg h-100 rounded-lg transform-hover"
                    style="border-bottom: 3px solid #007bff;">
                    <div class="mb-4 text-primary"><i class="fa fa-bolt fa-4x"></i></div>
                    <h4 class="font-weight-bold mb-3 text-white">Soluciones Ágiles</h4>
                    <p class="text-light-50 mb-0">Sabemos que el tiempo es dinero. Ofrecemos respuesta inmediata y logística
                        eficiente para que no pares.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-dark-glass py-5 mb-5"
        style="border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <div class="row text-center divide-cols">
                <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="zoom-in">
                    <h2 class="font-weight-bold text-warning display-4 mb-0">+10</h2>
                    <small class="text-uppercase letter-spacing-2 text-muted">Años de experiencia</small>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="100">
                    <h2 class="font-weight-bold text-warning display-4 mb-0">+500</h2>
                    <small class="text-uppercase letter-spacing-2 text-muted">Proyectos Atendidos</small>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <h2 class="font-weight-bold text-warning display-4 mb-0">+1k</h2>
                    <small class="text-uppercase letter-spacing-2 text-muted">Equipos Disponibles</small>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="300">
                    <h2 class="font-weight-bold text-warning display-4 mb-0">100%</h2>
                    <small class="text-uppercase letter-spacing-2 text-muted">Clientes Satisfechos</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Split -->
    <div class="container py-5 mb-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 pr-lg-5" data-aos="fade-right">
                <span class="badge badge-warning text-dark px-3 py-2 rounded-pill mb-3 font-weight-bold">NUESTRA
                    ESENCIA</span>
                <h2 class="font-weight-bold mb-4 display-5 text-white">Más que Renta de Maquinaria, <br>Somos tu Aliado en
                    Obra.</h2>
                <p class="lead text-light-50 mb-4">Rentimaq nació con una visión clara: transformar la industria del
                    alquiler
                    de maquinaria ofreciendo un servicio que va más allá de la transacción.</p>
                <p class="text-light-50 mb-4">Nos enfocamos en entender los retos de tu proyecto para ofrecerte exactamente
                    lo
                    que necesitas, cuando lo necesitas. Nuestra pasión es ver tus construcciones elevarse sin contratiempos.
                </p>
                <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-5 py-2 font-weight-bold">Ver
                    Catálogo</a>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <div class="position-absolute bg-warning rounded-lg"
                        style="width: 100%; height: 100%; top: 20px; left: 20px; z-index: -1; opacity: 0.8;"></div>
                    <img src="{{ asset('images/nosotros.png') }}" class="img-fluid rounded-lg shadow-lg w-100"
                        alt="Equipo Rentimaq" style="object-fit: cover; filter: brightness(0.9);">
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
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

        .transform-hover:hover {
            transform: translateY(-10px);
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
        }
    </style>
@endsection