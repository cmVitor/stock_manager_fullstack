<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    // GET /api/marcas
    public function index()
    {
        $brands = $this->brandService->getAll();
        return response()->json($brands);
    }

    // GET /api/marcas/{id}
    public function find($id)
    {
        $brand = $this->brandService->getById($id);
        return response()->json($brand);
    }

    // POST /api/marcas
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $brand = $this->brandService->create($data);
        return response()->json($brand, 201);
    }

    // PUT /api/marcas/{id}
    public function update(Request $request, $id)
    {
        $brand = $this->brandService->update($id, $request->all());
        return response()->json($brand);
    }

    // DELETE /api/marcas/{id}
    public function destroy($id)
    {
        $result = $this->brandService->delete($id);
        return response()->json($result);
    }

}
