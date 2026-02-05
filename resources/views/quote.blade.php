@extends('layouts.app')

@section('title', 'Cotización')

@section('content')
    <div style="background-color: #f4f4f4; min-height: 80vh;">
        <!-- Header / Banner -->
        <div class="container-fluid py-3 bg-dark text-white text-center"
            style="background-image: url('{{ asset('images/pattern-bg.png') }}');">
            <h1 class="font-weight-bold text-warning mb-2">Solicitar Cotización</h1>
            <p class="lead mb-0">Arma tu paquete de maquinaria y recibe una propuesta personalizada.</p>
        </div>

        <!-- Livewire Component -->
        <livewire:quote-builder />
    </div>
@endsection