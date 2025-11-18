<?php

namespace App\Http\Controllers;

use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    // GET /api/lotes
    public function index()
    {
        $suppliers = $this->supplierService->getSupplierDetails();
        return response()->json($suppliers);
    }
}
