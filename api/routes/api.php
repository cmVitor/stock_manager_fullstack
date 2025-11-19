<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API Estoque Online']);
});
Route::get('/marcas', [BrandController::class, 'index']);
Route::post('/marcas', [BrandController::class, 'store']);

Route::get('/lotes', [LotController::class, 'index']);

Route::get('/fornecedores', [SupplierController::class, 'index']);

Route::post('/movimentacao', [StockMovementController::class, 'store']);

Route::get('/estoque', [StockItemController::class, 'index']);

Route::get('/cidades/{uf}', [CityController::class, 'getCitiesByUf']);