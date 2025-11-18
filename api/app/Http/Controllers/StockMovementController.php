<?php

namespace App\Http\Controllers;

use App\Services\StockMovementService;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    protected $movementService;

    public function __construct(StockMovementService $movementService)
    {
        $this->movementService = $movementService;
    }

    public function store(Request $request)
    {
        try {
            $movement = $this->movementService->create($request->all());

            return response()->json([
                'message' => 'Movimentação criada com sucesso!',
                'data' => $movement
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Erro ao criar movimentação.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
