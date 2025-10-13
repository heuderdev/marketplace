<?php

use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/products', ProductList::class)->middleware(['auth'])->name('products');

Route::post('/pagamento/weebhook', [\App\Http\Controllers\MercadoLivreController::class, 'weebhook'])->name('pagamento.weebhook');
Route::get('/pagamento/success', [\App\Http\Controllers\MercadoLivreController::class, 'success'])->name('pagamento.success');
Route::get('/pagamento/failure', [\App\Http\Controllers\MercadoLivreController::class, 'failure'])->name('pagamento.failure');
Route::get('/pagamento/pending', [\App\Http\Controllers\MercadoLivreController::class, 'pending'])->name('pagamento.pending');

require __DIR__.'/auth.php';
