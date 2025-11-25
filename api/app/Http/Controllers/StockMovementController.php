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

    //POST /api/movements
    public function store(Request $request)
    {
        $movement = $this->movementService->create($request->all());

        return response()->json([
            'message' => 'Movimentação criada com sucesso!',
            'data' => $movement
        ], 201);
    }

    //GET /api/movements
    public function index()
    {
        $movements = $this->movementService->getAllMovementsWithItems();
        return response()->json($movements);
    }

    //DElETE /api/movements/{id}
    public function destroy($id)
    {
        return response()->json(
            $this->movementService->delete($id)
        );
    }

    public function show($id)
    {
        $movement = $this->movementService->getById($id);
        return response()->json($movement);
    }
}
