<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    // GET /api/Fornecedores
    public function index()
    {
        $suppliers = $this->supplierService->getSupplierDetails();
        return response()->json($suppliers);
    }

    //POST /api/fornecedores
    public function store(SupplierRequest $request)
    {
        $supplier = $this->supplierService->create($request->validated());
        return response()->json($supplier);
    }

    //UPDATE /api/fornecedores
    public function update(Request $request, $id)
    {
        $supplier = $this->supplierService->updateSupplierWithAddress($id, $request->all());
        return response()->json($supplier);
    }

    //DELETE /api/fornecedores{id}
    public function destroy($id)
    {
        return response()->json(
            $this->supplierService->delete($id)
        );
    }

    public function postSupplierAndAddress(SupplierRequest $request)
    {

        $supplier = $this->supplierService->createSupplierWithAddress($request->validated());

        return response()->json([
            'message' => 'Fornecedor criado com sucesso',
            'data' => $supplier->load('address')
        ], 201);
    }
}
