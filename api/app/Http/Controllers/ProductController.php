<?php

namespace App\Http\Controllers;

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
        $products = $this->productService->getAll();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = $this->productService->create($request->all());
        return response()->json($product, 201);
    }

    public function show($id)
    {
        $product = $this->productService->getById($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
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
