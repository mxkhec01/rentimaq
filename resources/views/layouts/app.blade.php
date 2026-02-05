<!DOCTYPE html>
<html lang="es-mx">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-164297646-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-164297646-1');
    </script>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NNHPMH4');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta_description', 'Rentimaq')">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/icon.png') }}">
    <title>Rentimaq | @yield('title', 'Home')</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/stylesheet2.css') }}" rel="stylesheet" type="text/css">

    <style>
        html {
            overflow-y: scroll; /* Force scrollbar track to always show to avoid layout shift */
        }
        .card {
            background-color: transparent;
        }

        .card-header {
            padding: 3px 0px;
        }

        .btn-link {
            width: 100%;
            color: white;
            background-color: rgba(255, 176, 9, 1);
        }

        .btn-link:hover {
            color: white;
            background-color: rgba(255, 176, 9, 0.7);
            text-decoration: none;
        }

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: transparent;
            border: solid 1px #ffc107;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #ffc107;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #ffc107;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        @media only screen and (max-width: 600px) {
            input.w-100 {
                width: 30px !important;
                height: 100% !important;
            }

            select.w-100 {
                width: 50px !important;
            }

            #lista {
                font-size: 10px;
            }
        }

        input.w-100 {

            height: 100% !important;
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NNHPMH4" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @include('layouts.partials.navbar')

    @yield('content')

    @include('layouts.partials.footer')

    @if(!request()->routeIs('home') && !request()->routeIs('quote'))
        <div class="botones-flotantes" style="bottom:20px;">
            <a href="{{ url('cotizacion') }}" wire:navigate>
                <button class="btn btn-warning">COTIZACIÓN</button>
            </a>
            <a href="https://api.whatsapp.com/send?phone=5214424754724" target="_blank">
                <button class="btn btn-success"><img src="{{ asset('images/whatsapp.svg') }}" width="25px">
                    CONTACTO</button>
            </a>
            <div class=" d-none d-sm-none d-md-block d-lg-block  d-xl-block">
                <a style="display:inline-block; padding-right:15px;" href="tel:2121210">
                    <figure>
                        <img src="{{ asset('images/phone.svg') }}" alt="Teléfono" width="40px">
                    </figure>
                </a>
                <a style="display:inline-block; padding-right:15px;" href="mailto:contacto@rentimaq.com">
                    <figure>
                        <img src="{{ asset('images/mail.svg') }}" alt="Mail" width="40px">
                    </figure>
                </a>
            </div>
        </div>
        <div class="botones-flotantes d-block d-sm-block d-md-none d-lg-none  d-xl-none">
            <div class="col-12">
                <div class="row">
                    <a class="col-6 text-left" href="tel:2121210" style="color:#ffc107;">Teléfono:(442)21 21 210</a>
                    <a class="col-6 text-right" href="mailto:contacto@rentimaq.com"
                        style="color:#ffc107;">contacto@rentimaq.com</a>
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>

    <script>
        $(document).ready(function () {
            AOS.init();
        });

        $('#carouselExampleControls').on('slide.bs.carousel', function () {
            $('#carouselExampleControls2').carousel('next');
            $('#carouselfrases').carousel('next');
        })

        $(".button-close").click(function (event) {
            $(".navbar-text").animate({ left: "-100%" }, 1000);
        });
        $(".button-open").click(function (event) {
            $(".navbar-text").css({ left: "-100%" });
            $(".navbar-text").css({ display: "block" });
            $(".navbar-text").animate({ left: "0%" }, 1000);
        });
        $("tr").click(function () {
            $("tr").removeClass("active");
            $(this).addClass("active");
            $(".prod-iz").removeClass("active");
            $("#rentimaq-" + $(this).attr("arg")).addClass("active");
        });

        $(".lista-categorias li").click(function () {
            $(".lista-categorias li").removeClass("active");
            $(this).addClass("active");
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>