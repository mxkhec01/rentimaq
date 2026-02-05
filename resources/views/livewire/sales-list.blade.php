<div>
@push('styles')
<style>
    /* Product Card */
    .product-card { 
        border:none; 
        border-radius:12px; 
        background: rgba(30, 30, 30, 0.6); 
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow:0 4px 6px rgba(0,0,0,0.2); 
        transition:transform 0.2s, box-shadow 0.2s; 
        height:100%; 
        overflow:hidden; 
        cursor:pointer; 
    }
    .product-card:hover { 
        transform:translateY(-5px); 
        box-shadow:0 10px 20px rgba(0,0,0,0.4); 
        border-color: rgba(255, 193, 7, 0.5);
    }
    .product-img-wrapper { 
        height:200px; 
        overflow:hidden; 
        background: rgba(0,0,0,0.2); 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        border-bottom:1px solid rgba(255, 255, 255, 0.1); 
    }
    .product-img { width:100%; height:100%; object-fit:cover; }
    .product-body { padding:20px; display:flex; flex-direction:column; justify-content:space-between; height:calc(100% - 200px); }
    .product-category { font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; color:#ffc107; font-weight:700; margin-bottom:8px; }
    .product-title { font-size:1.15rem; font-weight:700; color:#fff; margin-bottom:10px; line-height:1.3; }
    .product-desc { font-size:0.9rem; color:rgba(255,255,255,0.7); margin-bottom:15px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    .price-tag { font-weight:600; color:#fff; font-size:0.95rem; }
    .btn-details { background-color:#ffc107; color:#000; border:none; border-radius:25px; padding:8px 20px; font-weight:600; font-size:0.9rem; transition:background-color 0.2s; width:100%; margin-top:auto; }
    .btn-details:hover { background-color:#e0a800; color:#000; }

    /* Table Styles (Harmonized) */
    .rentals-table-card { 
        border-radius:12px; 
        border:none; 
        box-shadow:0 5px 15px rgba(0,0,0,0.2); 
        overflow:hidden; 
        background: rgba(30,30,30,0.6); 
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .rentals-table th { 
        background-color: rgba(0,0,0,0.3); 
        color:#ffc107; 
        font-weight:600; 
        text-transform:uppercase; 
        font-size:0.85rem; 
        letter-spacing:0.5px; 
        border-bottom:2px solid rgba(255,255,255,0.1); 
        vertical-align:middle; 
        padding:12px 15px; 
    }
    .rentals-table td { 
        vertical-align:middle; 
        padding:12px 15px; 
        border-bottom:1px solid rgba(255,255,255,0.05); 
        color:#fff; 
    }
    .rentals-table tbody tr { transition:background-color 0.1s; cursor:pointer; }
    .rentals-table tbody tr:last-child td { border-bottom:none; }
    .rentals-table tbody tr:hover { background-color: rgba(255, 193, 7, 0.1); }
    .table-img { width:45px; height:45px; object-fit:cover; border-radius:6px; border:1px solid rgba(255,255,255,0.1); }
    .table-price { font-weight:700; color:#fff; }
    .table-currency { font-size:0.75rem; color:rgba(255,255,255,0.5); font-weight:normal; }
    .text-muted { color: rgba(255,255,255,0.4) !important; }

    /* Modal Styling */
    .custom-modal-overlay { position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999; display:flex; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(8px); }
    .custom-modal { 
        background: #1a1a1a; 
        border: 1px solid rgba(255,255,255,0.1);
        border-radius:12px; 
        width:100%; 
        max-width:900px;
        max-height:90vh; 
        overflow-y:auto; 
        position:relative; 
        box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); 
        animation:slideIn 0.3s ease-out; 
    }
    @keyframes slideIn { from { transform:translateY(20px); opacity:0; } to { transform:translateY(0); opacity:1); } }
    .modal-close { position:absolute; top:15px; right:15px; background:rgba(255,255,255,0.1); border:none; width:35px; height:35px; border-radius:50%; font-size:1.2rem; color:#fff; cursor:pointer; z-index:10; transition:background 0.2s; display:flex; align-items:center; justify-content:center; }
    .modal-close:hover { background:rgba(255, 193, 7, 0.8); color: black; }
    .modal-header-img { height:300px; width:100%; object-fit:contain; background-color: rgba(0,0,0,0.2); }
    .modal-content-body { padding:30px; color: white; }
</style>
@endpush

<section class="container-fluid py-3">
    <div class="col-md-10 offset-md-1 p-0">
        <!-- Header -->
        <div class="row mb-4 align-items-center">
            <!-- Title Section -->
            <div class="col-lg-8 text-center text-lg-left">
                <h2 class="font-weight-bold mb-1" style="color: #fff; font-size: 2.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">Venta de Maquinaria</h2>
                <p class="mb-0" style="font-size: 1.1rem; color: rgba(255,255,255,0.7); text-shadow: 0 1px 2px rgba(0,0,0,0.8);">Equipos nuevos y seminuevos garantizados</p>
                <div class="d-lg-none" style="width: 60px; height: 4px; background: #ffc107; margin: 10px auto;"></div>
                <div class="d-none d-lg-block" style="width: 60px; height: 4px; background: #ffc107; margin: 10px 0;"></div>
            </div>

            <!-- Search Section -->
            <div class="col-lg-4 mt-3 mt-lg-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text border-0" style="background: rgba(20,20,20,0.8); border: 1px solid rgba(255,255,255,0.1); border-right: none; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                            <i class="fa fa-search text-warning"></i>
                        </span>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           class="form-control border-0 text-white" 
                           placeholder="Buscar equipo..." 
                           style="background: rgba(20,20,20,0.8); color: white !important; border: 1px solid rgba(255,255,255,0.1); border-left: none; border-top-right-radius: 20px; border-bottom-right-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
                </div>
            </div>
        </div>

        <!-- Grid View -->
        <div class="row">
            @foreach($products as $product)
                <div class="col-12 col-md-6 col-lg-4 mb-4" wire:key="sales-grid-{{ $product->id }}">
                    <div class="product-card h-100" wire:click="setActive({{ $product->id }})">
                        <div class="product-img-wrapper">
                            @if($product->image)
                                <img src="{{ Str::startsWith($product->image, 'images/') ? asset($product->image) : \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-img">
                            @else
                                <div class="text-white-50">Sin Imagen</div>
                            @endif
                        </div>
                        <div class="product-body">
                            <div>
                                <div class="product-category">{{ $product->category }}</div>
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <div class="product-desc">
                                    {!! strip_tags($product->description) !!}
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                @if($product->sale_price > 0)
                                    <div class="price-tag mb-2">
                                        <span style="color:#ffc107; font-size:1.2em;">${{ number_format($product->sale_price) }}</span> 
                                        <small class="text-muted">{{ $product->currency }}</small>
                                    </div>
                                @endif
                                <button class="btn-details">Ver Detalles</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Details Modal -->
@if($activeProductId)
    @php 
        $activeProduct = \App\Models\Product::find($activeProductId);
    @endphp
    @if($activeProduct)
        <div class="custom-modal-overlay" wire:click.self="setActive(null)">
            <div class="custom-modal">
                <button class="modal-close" wire:click="setActive(null)">&times;</button>
                
                <div class="row no-gutters">
                    <!-- Image Column -->
                    <div class="col-lg-5 d-flex align-items-center justify-content-center p-3" style="min-height: 300px; background-color: rgba(255,255,255,0.05);">
                        @if($activeProduct->image)
                            <img src="{{ Str::startsWith($activeProduct->image, 'images/') ? asset($activeProduct->image) : \Illuminate\Support\Facades\Storage::url($activeProduct->image) }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                        @else
                            <div class="text-muted">Sin Imagen</div>
                        @endif
                    </div>

                    <!-- Content Column -->
                    <div class="col-lg-7">
                        <div class="modal-content-body">
                            <span class="badge badge-warning text-dark mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">{{ $activeProduct->category }}</span>
                            <h2 class="font-weight-bold mb-3 text-white" style="font-size: 2rem; line-height: 1.2;">{{ $activeProduct->name }}</h2>
                            
                            <div class="mb-4 text-light-50" style="font-size: 0.95rem; line-height: 1.6; color: rgba(255,255,255,0.7);">
                                {!! $activeProduct->description !!}
                            </div>

                            @if($activeProduct->sale_price > 0)
                                <h3 class="font-weight-bold mb-4 text-warning">
                                    ${{ number_format($activeProduct->sale_price) }} <small class="text-white-50">{{ $activeProduct->currency }}</small>
                                </h3>
                            @endif

                            <div class="mt-4 pt-3 text-center text-lg-left">
                                <a href="https://api.whatsapp.com/send?phone=5214424754724&text=Me%20interesa%20comprar%20el%20equipo:%20{{ urlencode($activeProduct->name) }}" 
                                   target="_blank"
                                   class="btn btn-warning text-dark px-5 py-2 font-weight-bold rounded-pill shadow-sm hover-elevate">
                                    <i class="fa fa-whatsapp mr-2"></i> Solicitar Información
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
</div>