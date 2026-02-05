<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="{{ route('home') }}" wire:navigate>
        <figure>
            <img src="{{ asset('images/rentimaq.svg') }}" alt="Rentimaq" width="65%">
        </figure>
    </a>
    <button class="navbar-toggler button-open">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse show" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <!--a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a-->
            </li>
        </ul>
        <span class="navbar-text">
            <div class="col-12 d-block d-sm-block d-md-none d-lg-none d-xl-none">
                <div class="row">
                    <div class="col-4 p-0">
                        <figure>
                            <img src="{{ asset('images/rentimaq-black.svg') }}" width="100%" alt="Logo Rentimaq">
                        </figure>
                    </div>
                    <div class="col-8 text-right">
                        <span class="button-close">X</span>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}" wire:navigate>HOME <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('about') }}" wire:navigate>NOSOTROS</a>
                </li>
                <li class="nav-item {{ request()->routeIs('rentals.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('rentals.index') }}" wire:navigate>RENTA DE MAQUINARIA</a>
                </li>
                <li class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('sales.index') }}" wire:navigate>VENTA DE MAQUINARIA </a>
                </li>
                <li class="nav-item {{ request()->routeIs('invoicing') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('invoicing') }}" wire:navigate>FACTURACIÓN</a>
                </li>
                <li class="nav-item {{ request()->routeIs('quote') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('quote') }}" wire:navigate>COTIZACIÓN</a>
                </li>
                <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('contact') }}" wire:navigate>CONTACTO</a>
                </li>
                <li class="nav-item d-none d-sm-none d-md-block d-lg-block d-xl-block">
                    <a class="nav-link" href="https://web.facebook.com/Rentimaq-Qro-101847991428233/" target="_blank">
                        <figure>
                            <img src="{{ asset('images/facebook.svg') }}" alt="facebook" width="30px">
                        </figure>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-none d-md-block d-lg-block d-xl-block">
                    <a class="nav-link" href="https://www.instagram.com/rentimaq_qro/" target="_blank">
                        <figure>
                            <img src="{{ asset('images/instagram.svg') }}" alt="instagram" width="30px">
                        </figure>
                    </a>
                </li>
                <li class="nav-item d-block d-sm-block d-md-none d-lg-none d-xl-none">
                    <a class="nav-link" href="https://web.facebook.com/Rentimaq-Qro-101847991428233/" target="_blank"
                        style="display:inline-block;">
                        <figure style="display:inline-block;">
                            <img src="{{ asset('images/facebook.png') }}" alt="facebook rentimaq" width="40px">
                        </figure>
                    </a>
                    <a href="https://www.instagram.com/rentimaq_qro/" target="_blank" style="display:inline-block;">
                        <figure style="display:inline-block;">
                            <img src="{{ asset('images/instagram.png') }}" alt="instagram rentimaq" width="40px"
                                style="margin-top: -15px;">
                        </figure>
                    </a>
                </li>
            </ul>
        </span>
    </div>
</nav>