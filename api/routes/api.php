<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'API Estoque Online']);
});

// Rotas de Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

//Rotas de Users
Route::get('/usuarios', [UserController::class, 'index']);
Route::put('/usuarios/{id}', [UserController::class, 'update']);
Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

// Rotas de Brands
Route::get('/marcas', [BrandController::class, 'index']);
Route::post('/marcas', [BrandController::class, 'store']);
Route::put('/marcas/{id}', [BrandController::class, 'update']);
Route::delete('/marcas/{id}', [BrandController::class, 'destroy']);

Route::get('/lotes', [LotController::class, 'index']);

Route::get('/fornecedores', [SupplierController::class, 'index']);

Route::post('/movimentacao', [StockMovementController::class, 'store']);

Route::get('/estoque', [StockItemController::class, 'index']);

Route::get('/cidades/{uf}', [CityController::class, 'getCitiesByUf']);

Route::post('/fornecedores', [SupplierController::class, 'postSupplierAndAddress']);

Route::post('/lotes', [LotController::class, 'store']);