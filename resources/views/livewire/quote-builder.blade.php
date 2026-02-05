<div class="container-fluid py-5">

    @if (session()->has('success'))
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <div class="alert alert-success text-center p-5 shadow-sm" style="border-radius: 12px;">
                    <h3 class="font-weight-bold text-success"><i class="fa fa-check-circle"></i> ¡Enviado!</h3>
                    <p class="lead">{{ session('success') }}</p>
                    <button wire:click="$refresh" class="btn btn-outline-success mt-3 rounded-pill px-4">Nueva
                        Cotización</button>
                </div>
            </div>
        </div>
    @else

        <div class="row">
            <!-- LEFT COLUMN: Product Selector -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header text-white d-flex justify-content-between align-items-center py-3 px-4"
                        style="background: #1a1a1a;">
                        <h5 class="mb-0 font-weight-bold"><i class="fa fa-search text-warning"></i> Buscar Equipos</h5>
                    </div>
                    <div class="card-body">
                        <!-- Search Input -->
                        <div class="mb-4">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                class="form-control form-control-lg border-0 shadow-sm"
                                placeholder="¿Qué estás buscando? (Ej: Revolverdora, Vibrador...)">
                        </div>

                        <!-- Products Grid -->
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-4 col-sm-6 mb-4" wire:key="prod-{{ $product->id }}">
                                    <div class="product-card h-100 bg-white border-0 shadow-sm position-relative"
                                        wire:click="addToQuote({{ $product->id }})"
                                        style="border-radius: 10px; overflow: hidden; transition: all 0.2s; cursor: pointer; border: 1px solid transparent;">

                                        <style>
                                            .product-card:hover {
                                                transform: translateY(-3px);
                                                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
                                                border-color: #ffc107 !important;
                                            }
                                        </style>

                                        <!-- Loading Overlay -->
                                        <div wire:loading.flex wire:target="addToQuote({{ $product->id }})"
                                            class="position-absolute w-100 h-100 justify-content-center align-items-center"
                                            style="background: rgba(255,255,255,0.7); z-index: 10; top: 0; left: 0; display: none;">
                                            <i class="fa fa-spinner fa-spin text-warning fa-2x"></i>
                                        </div>

                                        <div
                                            style="height: 140px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                            @if($product->image)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                                                    style="height: 100%; width: 100%; object-fit: cover;">
                                            @else
                                                <span class="text-muted small">Sin imagen</span>
                                            @endif
                                        </div>
                                        <div class="p-3 text-center d-flex flex-column h-100">
                                            <h6 class="font-weight-bold text-dark mb-1 text-truncate"
                                                title="{{ $product->name }}">{{ $product->name }}</h6>
                                            <div class="text-warning small font-weight-bold mb-3">{{ $product->category }}</div>

                                            <!-- Visual Button -->
                                            <div
                                                class="btn btn-warning btn-sm btn-block text-white font-weight-bold rounded-pill mt-auto shadow-sm">
                                                <i class="fa fa-plus"></i> Agregar
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Quote Cart & Form -->
            <div class="col-lg-5">
                <div class="card shadow-lg border-0"
                    style="border-radius: 12px; overflow: hidden; position: sticky; top: 20px;">
                    <div class="card-header text-white py-3 px-4 d-flex justify-content-between align-items-center"
                        style="background: #1a1a1a;">
                        <h5 class="mb-0 font-weight-bold">Mi Cotización</h5>
                        <span class="badge badge-warning text-dark">{{ count($quoteItems) }} Artículos</span>
                    </div>

                    <div class="card-body">
                        <!-- Error Handling -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Selected Items List -->
                        @if(count($quoteItems) > 0)
                            <div class="selected-items-list mb-4"
                                style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                                @foreach($quoteItems as $index => $item)
                                    <div class="cart-item bg-white border-0 shadow-sm p-3 mb-3 position-relative"
                                        wire:key="cart-item-{{ $index }}" style="border-radius: 12px; transition: transform 0.2s;">

                                        <!-- Remove Button (Badge Style) -->
                                        <button wire:click="removeFromQuote({{ $index }})"
                                            class="btn btn-sm btn-light text-danger font-weight-bold shadow-sm d-flex align-items-center px-3 position-absolute hover-red-bg"
                                            style="top: 10px; right: 10px; z-index: 10; border-radius: 20px; font-size: 0.75rem; border: 1px solid rgba(220, 53, 69, 0.15); background: #fff5f5; transition: all 0.2s;"
                                            title="Eliminar artículo">
                                            <i class="fa fa-trash-o mr-1"></i> Eliminar
                                        </button>

                                        <div class="d-flex align-items-start">
                                            <!-- Image -->
                                            <div class="flex-shrink-0 mr-3 text-center" style="width: 80px;">
                                                <div class="rounded overflow-hidden mb-2"
                                                    style="height: 60px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 1px solid #eee;">
                                                    @if($item['image'])
                                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($item['image']) }}"
                                                            class="img-fluid"
                                                            style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                                    @else
                                                        <i class="fa fa-image text-muted fa-lg"></i>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Details -->
                                            <div class="flex-grow-1 pr-4">
                                                <h6 class="font-weight-bold text-dark mb-2 text-truncate"
                                                    title="{{ $item['name'] }}">
                                                    {{ $item['name'] }}
                                                </h6>

                                                <!-- Type Selector (Segmented Control) -->
                                                @if($item['allow_rent'] && $item['allow_sale'])
                                                    <div class="btn-group btn-group-sm w-100 mb-3" role="group"
                                                        style="background: #f1f3f5; padding: 3px; border-radius: 8px;">
                                                        <button type="button"
                                                            wire:click="$set('quoteItems.{{ $index }}.transaction_type', 'rent')"
                                                            class="btn border-0 rounded py-1 px-2 {{ $item['transaction_type'] === 'rent' ? 'bg-white shadow-sm font-weight-bold text-dark' : 'text-muted' }}"
                                                            style="transition: all 0.2s;">
                                                            Renta
                                                        </button>
                                                        <button type="button"
                                                            wire:click="$set('quoteItems.{{ $index }}.transaction_type', 'sale')"
                                                            class="btn border-0 rounded py-1 px-2 {{ $item['transaction_type'] === 'sale' ? 'bg-white shadow-sm font-weight-bold text-dark' : 'text-muted' }}"
                                                            style="transition: all 0.2s;">
                                                            Venta
                                                        </button>
                                                    </div>
                                                @elseif($item['transaction_type'] === 'rent')
                                                    <div class="badge badge-light text-dark font-weight-bold mb-2 px-3 py-2 border border-light"
                                                        style="border-radius: 6px;">
                                                        <i class="fa fa-clock-o mr-1 text-warning"></i> Solo Renta
                                                    </div>
                                                @else
                                                    <div class="badge badge-light text-dark font-weight-bold mb-2 px-3 py-2 border border-light"
                                                        style="border-radius: 6px;">
                                                        <i class="fa fa-shopping-bag mr-1 text-warning"></i> Solo Venta
                                                    </div>
                                                @endif

                                                <!-- Inputs Row -->
                                                <div class="row no-gutters align-items-end">
                                                    <!-- Quantity -->
                                                    <div class="col-5 pr-2">
                                                        <label class="small text-muted font-weight-bold text-uppercase mb-1"
                                                            style="font-size: 0.65rem; letter-spacing: 0.5px;">Cant.</label>
                                                        <div class="input-group input-group-sm" style="width: 120px;">
                                                            <div class="input-group-prepend">
                                                                <button
                                                                    class="btn btn-light border font-weight-bold p-0 d-flex align-items-center justify-content-center"
                                                                    type="button"
                                                                    style="background-color: #e9ecef !important; border-color: #ced4da !important; height: 30px !important; width: 30px !important;"
                                                                    wire:click="updateItemQty({{ $index }}, -1)">
                                                                    <span
                                                                        style="font-size: 1.2rem; line-height: 1; color: black !important; font-weight: 900 !important;">-</span>
                                                                </button>
                                                            </div>
                                                            <input type="text" readonly value="{{ $item['qty'] }}"
                                                                class="form-control text-center font-weight-bold bg-white border-top border-bottom p-0"
                                                                style="color: #000000 !important; height: 30px !important;">
                                                            <div class="input-group-append">
                                                                <button
                                                                    class="btn btn-light border font-weight-bold p-0 d-flex align-items-center justify-content-center"
                                                                    type="button"
                                                                    style="background-color: #e9ecef !important; border-color: #ced4da !important; height: 30px !important; width: 30px !important;"
                                                                    wire:click="updateItemQty({{ $index }}, 1)">
                                                                    <span
                                                                        style="font-size: 1.2rem; line-height: 1; color: black !important; font-weight: 900 !important;">+</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Duration (Rent Only) -->
                                                    @if($item['transaction_type'] === 'rent')
                                                        <div class="col-7">
                                                            <label class="small text-muted font-weight-bold text-uppercase mb-1"
                                                                style="font-size: 0.65rem; letter-spacing: 0.5px;">Tiempo</label>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <button
                                                                        class="btn btn-light border font-weight-bold p-0 d-flex align-items-center justify-content-center"
                                                                        type="button"
                                                                        style="background-color: #e9ecef !important; border-color: #ced4da !important; height: 30px !important; width: 30px !important;"
                                                                        wire:click="updateItemDuration({{ $index }}, -1)">
                                                                        <span
                                                                            style="font-size: 1.2rem; line-height: 1; color: black !important; font-weight: 900 !important;">-</span>
                                                                    </button>
                                                                </div>
                                                                <input type="text" readonly value="{{ $item['duration'] }}"
                                                                    class="form-control text-center font-weight-bold bg-white border-top border-bottom p-0"
                                                                    style="max-width: 50px; color: #000000 !important; height: 30px !important;">
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn btn-light border font-weight-bold p-0 d-flex align-items-center justify-content-center"
                                                                        type="button"
                                                                        style="background-color: #e9ecef !important; border-color: #ced4da !important; height: 30px !important; width: 30px !important;"
                                                                        wire:click="updateItemDuration({{ $index }}, 1)">
                                                                        <span
                                                                            style="font-size: 1.2rem; line-height: 1; color: black !important; font-weight: 900 !important;">+</span>
                                                                    </button>
                                                                </div>
                                                                <div class="input-group-append flex-grow-1">
                                                                    <select wire:model.blur="quoteItems.{{ $index }}.period"
                                                                        class="custom-select bg-light border-0 font-weight-bold text-dark p-0 pl-2"
                                                                        style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; height: 30px !important; font-size: 0.85rem;">
                                                                        <option value="day" class="text-dark">Días</option>
                                                                        <option value="week" class="text-dark">Semanas</option>
                                                                        <option value="month" class="text-dark">Meses</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <div class="mb-3">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px;">
                                        <i class="fa fa-shopping-cart fa-2x text-warning" style="opacity: 0.5;"></i>
                                    </div>
                                </div>
                                <h6 class="font-weight-bold text-dark">Tu cotización está vacía</h6>
                                <p class="text-secondary mt-2">Busca equipos y agrégalos para comenzar.</p>
                            </div>
                        @endif

                        <hr>

                        <!-- Contact Form -->
                        <h6 class="font-weight-bold text-uppercase text-secondary mb-3">Tus Datos</h6>
                        <div class="form-row">
                            <div class="col-6 mb-3">
                                <input type="text" wire:model.defer="contact.name" class="form-control"
                                    placeholder="Nombre Completo *">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" wire:model.defer="contact.company" class="form-control"
                                    placeholder="Empresa *">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-6 mb-3">
                                <input type="email" wire:model.defer="contact.email" class="form-control"
                                    placeholder="Correo Electrónico *">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="tel" wire:model.defer="contact.phone" class="form-control"
                                    placeholder="Teléfono *">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <input type="text" wire:model.defer="contact.city" class="form-control"
                                    placeholder="Ciudad *">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" wire:model.defer="contact.address" class="form-control"
                                    placeholder="Dirección Obra *">
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea wire:model.defer="contact.message" class="form-control" rows="2"
                                placeholder="Notas adicionales o dudas..."></textarea>
                        </div>

                        <button wire:click="submitQuote"
                            class="btn btn-warning btn-block text-white font-weight-bold rounded-pill py-3 shadow hover-lift"
                            @if(count($quoteItems) == 0) disabled @endif>
                            <i class="fa fa-paper-plane mr-2"></i> ENVIAR COTIZACIÓN
                        </button>

                        <div wire:loading wire:target="submitQuote" class="text-center mt-2 text-muted">
                            <i class="fa fa-spinner fa-spin"></i> Enviando...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Toast Notification -->
    <div id="toast-quote-builder" style="position: fixed; top: 110px; right: 30px; z-index: 10000; display: none;">
        <div class="d-flex align-items-center px-4 py-3 shadow-sm" style="
                background: rgba(30, 30, 30, 0.65); 
                backdrop-filter: blur(8px);
                border-radius: 30px; 
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.1);
                animation: slideInFade 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
             ">
            <i class="fa fa-check text-success mr-3"
                style="font-size: 1.1rem; background: rgba(255,255,255,0.1); padding: 5px; border-radius: 50%;"></i>
            <span class="font-weight-bold mr-2" style="font-size: 0.95rem;">Producto agregado correctamente</span>
        </div>
    </div>

    <style>
        @keyframes slideInFade {
            from {
                transform: translateX(20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('product-added-to-quote-builder', (event) => {
                const toast = document.getElementById('toast-quote-builder');
                toast.style.display = 'block';
                setTimeout(() => { toast.style.display = 'none'; }, 3000);
            });
        });
    </script>
</div>

@push('styles')
    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .badge-warning {
            background-color: #ffc107;
        }
    </style>
@endpush