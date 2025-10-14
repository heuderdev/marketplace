<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/pagamento/weebhook', [\App\Http\Controllers\MercadoLivreController::class, 'weebhook'])->name('pagamento.weebhook');