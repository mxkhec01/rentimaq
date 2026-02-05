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
        max-width:900px; /* Wider modal */
        max-height:90vh; 
        overflow-y:auto; 
        position:relative; 
        box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); 
        animation:slideIn 0.3s ease-out; 
    }
    @keyframes slideIn { from { transform:translateY(20px); opacity:0; } to { transform:translateY(0); opacity:1; } }
    .modal-close { position:absolute; top:15px; right:15px; background:rgba(255,255,255,0.1); border:none; width:35px; height:35px; border-radius:50%; font-size:1.2rem; color:#fff; cursor:pointer; z-index:10; transition:background 0.2s; display:flex; align-items:center; justify-content:center; }
    .modal-close:hover { background:rgba(255, 193, 7, 0.8); color: black; }
    .modal-header-img { height:300px; width:100%; object-fit:contain; background-color: rgba(0,0,0,0.2); }
    .modal-content-body { padding:30px; color: white; }
    .price-list-table { width:100%; margin-top:20px; border-collapse:separate; border-spacing:0; border:1px solid rgba(255,255,255,0.1); border-radius:8px; overflow:hidden; }
    .price-list-table th, .price-list-table td { padding:12px 15px; text-align:left; border-bottom:1px solid rgba(255,255,255,0.1); color: #fff; }
    .price-list-table th { background-color:rgba(0,0,0,0.3); font-weight:600; color:#ffc107; }
    .price-list-table tr:last-child td { border-bottom:none; }
</style>
@endpush

<section class="container-fluid py-3">
    <div class="col-md-10 offset-md-1 p-0">
        <!-- Header -->
        <div class="row mb-4 align-items-center">
            <!-- Title Section -->
            <div class="col-lg-8 text-center text-lg-left">
                <h2 class="font-weight-bold mb-1" style="color: #fff; font-size: 2.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">Catálogo de Maquinaria</h2>
                <p class="mb-0" style="font-size: 1.1rem; color: rgba(255,255,255,0.7); text-shadow: 0 1px 2px rgba(0,0,0,0.8);">Encuentra el equipo perfecto para tu proyecto</p>
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
                           placeholder="Buscar equipo, categoría..." 
                           style="background: rgba(20,20,20,0.8); color: white !important; border: 1px solid rgba(255,255,255,0.1); border-left: none; border-top-right-radius: 20px; border-bottom-right-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
                </div>
            </div>
        </div>

        <!-- Mobile/Tablet Grid View (< LG) -->
        <div class="row d-lg-none">
            @foreach($products as $product)
                <div class="col-12 col-md-6 mb-4" wire:key="grid-{{ $product->id }}">
                    <div class="product-card h-100" wire:click="setActive({{ $product->id }})">
                        <div class="product-img-wrapper">
                            @if($product->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-img">
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
                            
                            @php 
                                $dayPrice = $product->rentalPrices->firstWhere('rental_period_id', 1); 
                            @endphp

                            <div class="mt-3">
                                @if($dayPrice)
                                    <div class="price-tag mb-2">
                                        Desde <span style="color:#ffc107; font-size:1.2em;">${{ number_format($dayPrice->price) }}</span> / día
                                    </div>
                                @endif
                                <button class="btn-details">Ver Detalles</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop Table View (>= LG) -->
        <div class="row d-none d-lg-block">
            <div class="col-12">
                <div class="card rentals-table-card">
                    <div class="table-responsive">
                        <table class="table rentals-table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;"></th>
                                    <th>Equipo</th>
                                    <th>Categoría</th>
                                    @foreach($periods as $period)
                                        <th class="text-right">{{ $period->label }}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr wire:click="setActive({{ $product->id }})" wire:key="table-{{ $product->id }}">
                                        <td>
                                            @if($product->image)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" class="table-img">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-weight-bold display-6" style="font-size: 1.05rem; color: #fff;">{{ $product->name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge badge-dark border border-secondary text-warning">{{ $product->category }}</span>
                                        </td>
                                        @foreach($periods as $period)
                                            <td class="text-right">
                                                @php 
                                                    $price = $product->rentalPrices->firstWhere('rental_period_id', $period->id);
                                                @endphp
                                                @if($price)
                                                    <div class="table-price">${{ number_format($price->price) }}</div>
                                                    <div class="table-currency">{{ $price->currency }}</div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="text-center">
                                            <i class="fa fa-chevron-right text-muted"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Details Modal -->
@if($activeProductId)
    @php 
        // Force fresh load with relations to ensure pricing data is available
        $activeProduct = \App\Models\Product::with(['rentalPrices.rentalPeriod'])->find($activeProductId);
    @endphp
    @if($activeProduct)
        <div class="custom-modal-overlay" wire:click.self="setActive(null)">
            <div class="custom-modal">
                <button class="modal-close" wire:click="setActive(null)">&times;</button>
                
                <div class="row no-gutters">
                    <!-- Image Column -->
                    <div class="col-lg-5 d-flex align-items-center justify-content-center p-3" style="min-height: 300px; background-color: rgba(255,255,255,0.05);">
                        @if($activeProduct->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($activeProduct->image) }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
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

                            <h5 class="font-weight-bold mb-3 text-warning">Precios de Renta</h5>
                            <div class="table-responsive">
                                <table class="price-list-table mb-0">
                                    <thead>
                                        <tr>
                                            <th style="padding: 10px 15px; font-size: 0.9rem;">Periodo</th>
                                            <th style="padding: 10px 15px; font-size: 0.9rem;">Precio</th>
                                            <th style="padding: 10px 15px; font-size: 0.9rem;">Moneda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeProduct->rentalPrices as $price)
                                            <tr>
                                                <td class="font-weight-bold" style="padding: 10px 15px; font-size: 0.95rem;">{{ $price->rentalPeriod->label ?? 'N/A' }}</td>
                                                <td style="padding: 10px 15px; font-size: 0.95rem;">${{ number_format($price->price, 2) }}</td>
                                                <td style="padding: 10px 15px; font-size: 0.95rem;">{{ $price->currency }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 pt-3 text-center text-lg-left">
                                <button wire:click="addToQuote({{ $activeProduct->id }})" 
                                        wire:loading.attr="disabled"
                                        class="btn btn-warning text-dark px-5 py-2 font-weight-bold rounded-pill shadow-sm hover-elevate">
                                    <span wire:loading.remove wire:target="addToQuote({{ $activeProduct->id }})">Solicitar Cotización</span>
                                    <span wire:loading wire:target="addToQuote({{ $activeProduct->id }})">
                                        <i class="fa fa-spinner fa-spin mr-2"></i> Procesando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
</div>