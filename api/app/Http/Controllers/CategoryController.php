<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // GET /api/categorias
    public function index()
    {
        $categories = $this->categoryService->getAll();
        return response()->json($categories);
    }

    // GET /api/categorias/{id}
    public function show($id)
    {
        $category = $this->categoryService->getById($id);
        return response()->json($category);
    }

    // POST /api/categorias
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        return response()->json($category, 201);
    }

    // PUT /api/categorias/{id}
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->update($id, $request->validated());
        return response()->json($category);
    }

    // DELETE /api/marcas/{id}
    public function destroy($id)
    {
        return response()->json(
            $this->categoryService->delete($id)
        );
    }
}
