<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/nosotros', [PageController::class, 'about'])->name('about');
Route::get('/renta-de-maquinaria', [RentalController::class, 'index'])->name('rentals.index');
Route::get('/venta-de-maquinaria', [SaleController::class, 'index'])->name('sales.index');
Route::get('/facturacion', [PageController::class, 'invoicing'])->name('invoicing');
Route::get('/cotizacion', [QuoteController::class, 'index'])->name('quote');
Route::get('/contacto', [ContactController::class, 'index'])->name('contact');

// Form submissions
Route::post('/cotizacion', [QuoteController::class, 'store'])->name('quote.store');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');