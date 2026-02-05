@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <!-- Floating Hero Section -->
    <div class="position-relative d-flex align-items-center justify-content-center" 
         style="min-height: 100vh; background: url('{{ asset('images/home_hero.png') }}') no-repeat center center fixed; background-size: cover; padding-top: 60px; padding-bottom: 20px;">
        
        <!-- Dark Overlay -->
        <div class="position-absolute w-100 h-100" style="background: rgba(0,0,0,0.6); top:0; left:0;"></div>
        
        <!-- Main Container -->
        <div class="container position-relative z-index-1">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    
                    <!-- Dark Glass Card -->
                    <div class="card shadow-lg border-0 rounded-lg overflow-hidden backdrop-blur-dark" data-aos="fade-up">
                        <div class="row no-gutters">
                            
                            <!-- Left: Contact Info -->
                            <div class="col-md-5 d-flex flex-column justify-content-center p-4 text-white" 
                                 style="background: rgba(255, 193, 7, 0.95); position: relative; overflow: hidden;">
                                
                                <!-- Pattern Overlay -->
                                <div class="position-absolute w-100 h-100" 
                                     style="top:0; left:0; background: url('{{ asset('images/pattern.png') }}'); opacity: 0.05;"></div>
                                
                                <div class="position-relative z-index-1 text-dark">
                                    <h5 class="font-weight-bold text-uppercase mb-4">Información de Contacto</h5>
                                    
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="mr-3 mt-1"><i class="fa fa-map-marker fa-lg"></i></div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0" style="font-size: 0.95rem;">Ubicación</h6>
                                            <p class="small mb-0" style="opacity: 0.8; line-height: 1.4;">
                                                Carretera a Tlacote 184,<br>
                                                Col. La Piedad, 76150<br>
                                                Santiago de Querétaro, Qro.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="mr-3"><i class="fa fa-phone fa-lg"></i></div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0" style="font-size: 0.95rem;">Teléfono</h6>
                                            <a href="tel:4422121210" class="text-dark small font-weight-bold" style="text-decoration: none;">(442) 212 1210</a>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-4">
                                        <div class="mr-3"><i class="fa fa-envelope fa-lg"></i></div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0" style="font-size: 0.95rem;">Email</h6>
                                            <a href="mailto:contacto@rentimaq.com" class="text-dark small font-weight-bold" style="text-decoration: none;">contacto@rentimaq.com</a>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="font-weight-bold mb-2 icon-label" style="font-size: 0.9rem;">Síguenos</h6>
                                        <div class="d-flex">
                                            <a href="https://web.facebook.com/Rentimaq-Qro-101847991428233/" target="_blank" class="social-btn mr-2" title="Facebook">
                                                <img src="{{ asset('images/facebook.svg') }}" alt="Facebook" style="width: 20px; height: 20px;">
                                            </a>
                                            <a href="https://www.instagram.com/rentimaq_qro/" target="_blank" class="social-btn" title="Instagram">
                                                <img src="{{ asset('images/instagram.svg') }}" alt="Instagram" style="width: 20px; height: 20px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Contact Form -->
                            <div class="col-md-7 p-4">
                                <div class="text-left mb-3">
                                    <h4 class="font-weight-bold text-white mb-1">Envíanos un mensaje</h4>
                                    <p class="text-muted small mb-0">Estamos listos para atender tus requerimientos.</p>
                                </div>

                                <form action="{{ route('contact.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="Contacto">
                                    
                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold text-light small opacity-60 mb-1">Nombre Completo</label>
                                        <input type="text" name="nombre" class="form-control form-control-dark form-control-sm" required placeholder="Tu nombre">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-2">
                                            <label class="font-weight-bold text-light small opacity-60 mb-1">Email</label>
                                            <input type="email" name="correo" class="form-control form-control-dark form-control-sm" required placeholder="tucorreo@ejemplo.com">
                                        </div>
                                        <div class="col-md-6 form-group mb-2">
                                            <label class="font-weight-bold text-light small opacity-60 mb-1">Empresa</label>
                                            <input type="text" name="empresa" class="form-control form-control-dark form-control-sm" required placeholder="Nombre de tu empresa">
                                        </div>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label class="font-weight-bold text-light small opacity-60 mb-1">Asunto</label>
                                        <input type="text" name="asunto" class="form-control form-control-dark form-control-sm" required placeholder="¿En qué podemos ayudarte?">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold text-light small opacity-60 mb-1">Mensaje</label>
                                        <textarea name="mensaje" class="form-control form-control-dark form-control-sm" rows="3" required placeholder="Escribe tus comentarios..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-warning btn-block py-2 rounded-pill shadow font-weight-bold transform-hover text-dark btn-sm">
                                        ENVIAR MENSAJE
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .backdrop-blur-dark { 
            background-color: rgba(20, 20, 20, 0.85); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .rounded-lg { border-radius: 1rem !important; }
        .opacity-60 { opacity: 0.6; }
        
        .social-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #ffffff; /* White background for logos */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            text-decoration: none !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .social-btn:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        /* Dark Inputs Styling */
        .form-control-dark {
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff !important; /* Force white text */
            transition: all 0.2s ease;
            font-size: 0.9rem;
            padding: 0.4rem 0.75rem; /* Reduced padding */
        }
        .form-control-dark:focus {
            background-color: rgba(0, 0, 0, 0.6);
            border: 1px solid #ffc107;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }
        
        /* Autofill override */
        .form-control-dark:-webkit-autofill,
        .form-control-dark:-webkit-autofill:hover, 
        .form-control-dark:-webkit-autofill:focus, 
        .form-control-dark:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #333 inset !important;
            -webkit-text-fill-color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .transform-hover:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 20px rgba(255, 193, 7, 0.3) !important; 
        }
        
        .form-control-dark::placeholder { opacity: 0.6; font-size: 0.85rem; color: rgba(255,255,255,0.7); }
    </style>
@endsection