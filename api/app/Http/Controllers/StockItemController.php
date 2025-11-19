<?php

namespace App\Http\Controllers;

use App\Services\StockItemService;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    protected $stockItemService;

    public function __construct(StockItemService $stockItemService)
    {
        $this->stockItemService = $stockItemService;
    }

    //GET /api/estoque
    public function index()
    {
        $stockItems = $this->stockItemService->getStockDetails();
        return response()->json($stockItems);
    }

    //DELETE /api/estoque/{id}
    public function destroy($id)
    {
        return response()->json(
            $this->stockItemService->delete($id)
        );
    }
}
