<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API Estoque Online']);
});
Route::get('/marcas', [BrandController::class, 'index']);
Route::post('/marcas', [BrandController::class, 'store']);

Route::get('/lotes', [LotController::class, 'index']);

Route::get('/fornecedores', [SupplierController::class, 'index']);