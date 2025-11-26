<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
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


//Rotas de localidade
Route::get('/cidades/{uf}', [CityController::class, 'getCitiesByUf']);
Route::get('/estados', [StateController::class, 'index']);

Route::get('/unidades', [UnitController::class, 'index']);


Route::middleware('auth:api')->group(function () {
    //Rotas de Products
    Route::get('/produtos', [ProductController::class, 'index']);
    Route::post('/produtos', [ProductController::class, 'store']);
    Route::delete('/produtos/{id}', [ProductController::class, 'destroy']);
    Route::put('/produtos/{id}', [ProductController::class, 'update']);

    //Rotas de moviments
    Route::post('/movements', [StockMovementController::class, 'store']);
    Route::get('/movements', [StockMovementController::class, 'index']);

    //Gets necessarios pra usuario normal
    Route::get('/estoque', [StockItemController::class, 'index']);
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::get('/marcas', [BrandController::class, 'index']);
    Route::get('/categorias', [CategoryController::class, 'index']);
    Route::get('/lotes', [LotController::class, 'index']);
    Route::get('/fornecedores', [SupplierController::class, 'index']);
});

Route::middleware('auth:api', 'admin')->group(function () {
    //Rotas de Users
    
    Route::put('/usuarios/{id}', [UserController::class, 'update']);        
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

    // Rotas de Brands
    Route::post('/marcas', [BrandController::class, 'store']);
    Route::put('/marcas/{id}', [BrandController::class, 'update']);
    Route::delete('/marcas/{id}', [BrandController::class, 'destroy']);

    // Rotas de Categories
    Route::post('/categorias', [CategoryController::class, 'store']);
    Route::put('/categorias/{id}', [CategoryController::class, 'update']);
    Route::delete('/categorias/{id}', [CategoryController::class, 'destroy']);

    //Rotas de Lots
    Route::post('/lotes', [LotController::class, 'store']);
    Route::put('/lotes/{id}', [LotController::class, 'update']);       //atualizar service de update com deposit locations
    Route::delete('/lotes/{id}', [LotController::class, 'destroy']);

    //Rotas de Suppliers
    Route::post('/fornecedores', [SupplierController::class, 'postSupplierAndAddress']);
    Route::delete('/fornecedores/{id}', [SupplierController::class, 'destroy']);
    Route::put('/fornecedores/{id}', [SupplierController::class, 'update']);
});
