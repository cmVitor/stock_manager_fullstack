<?php

namespace App\Http\Controllers;

use App\Services\LotService;
use Illuminate\Http\Request;

class LotController extends Controller
{
    protected $lotService;

    public function __construct(LotService $lotService)
    {
        $this->lotService = $lotService;
    }

    // GET /api/lotes
    public function index()
    {
        $lots = $this->lotService->getAll();
        return response()->json($lots);
    }

    // POST /api/lotes
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
            'expiration_date' => 'required|date',
            'deposit_location_id' => 'required|integer'
        ]);

        $lot = $this->lotService->create($data);
        return response()->json($lot, 201);
    }
}
