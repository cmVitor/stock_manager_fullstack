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

    public function index()
    {
        $stockItems = $this->stockItemService->getStockDetails();
        return response()->json($stockItems);
    }
}
