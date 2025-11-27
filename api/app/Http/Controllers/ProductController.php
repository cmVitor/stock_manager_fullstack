<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getProductDetails();
        return response()->json($products);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productService->create($request->validated());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = $this->productService->getById($id);
        return response()->json($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->update($id, $request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        return response()->json(
            $this->productService->delete($id)
        );
    }
}
