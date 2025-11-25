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
Route::put('/usuarios/{id}', [UserController::class, 'update']);        //atualizar service de update com address
Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

// Rotas de Brands
Route::get('/marcas', [BrandController::class, 'index']);
Route::post('/marcas', [BrandController::class, 'store']);
Route::put('/marcas/{id}', [BrandController::class, 'update']);
Route::delete('/marcas/{id}', [BrandController::class, 'destroy']);

// Rotas de Categories
Route::get('/categorias', [CategoryController::class, 'index']);
Route::post('/categorias', [CategoryController::class, 'store']);
Route::put('/categorias/{id}', [CategoryController::class, 'update']);      
Route::delete('/categorias/{id}', [CategoryController::class, 'destroy']);

//Rotas de Lots
Route::post('/lotes', [LotController::class, 'store']);
Route::get('/lotes', [LotController::class, 'index']);
Route::put('/lotes/{id}', [LotController::class, 'update']);       //atualizar service de update com deposit locations
Route::delete('/lotes/{id}', [LotController::class, 'destroy']);

//Rotas de Suppliers
Route::get('/fornecedores', [SupplierController::class, 'index']);
Route::post('/fornecedores', [SupplierController::class, 'postSupplierAndAddress']);
Route::delete('/fornecedores/{id}', [SupplierController::class, 'destroy']);
Route::put('/fornecedores/{id}', [SupplierController::class, 'update']);

//Rotas de Products
Route::get('/produtos', [ProductController::class, 'index']);
Route::post('/produtos', [ProductController::class, 'store']);
Route::delete('/produtos/{id}', [ProductController::class, 'destroy']);
Route::put('/produtos/{id}', [ProductController::class, 'update']);

//Rotas de localidade
Route::get('/cidades/{uf}', [CityController::class, 'getCitiesByUf']);
Route::get('/estados', [StateController::class, 'index']);

//Rotas de moviments
Route::post('/movements', [StockMovementController::class, 'store']);
Route::get('/movements', [StockMovementController::class, 'index']);

Route::get('/estoque', [StockItemController::class, 'index']);


