<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
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
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search'); 

        $brands = $this->brandService->getPaginated($perPage, $search);

        return BrandResource::collection($brands);
    }

    // GET /api/marcas/{id}
    public function show($id)
    {
        $brand = $this->brandService->getById($id);
        return response()->json($brand);
    }

    // POST /api/marcas
    public function store(BrandRequest $request)
    {
        $brand = $this->brandService->create($request->validated());
        return response()->json($brand, 201);
    }

    // PUT /api/marcas/{id}
    public function update(BrandRequest $request, $id)
    {
        $brand = $this->brandService->update($id, $request->validated());
        return response()->json($brand);
    }

    // DELETE /api/marcas/{id}
    public function destroy($id)
    {
        return response()->json(
            $this->brandService->delete($id)
        );
    }
}
