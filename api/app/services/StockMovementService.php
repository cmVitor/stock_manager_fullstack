<?php

namespace App\Services;

use App\Repositories\Eloquent\StockMovementRepository;
use App\Repositories\Eloquent\MovementItemRepository;
use App\services\StockItemService;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    protected $movementRepo;
    protected $itemRepo;
    protected $stockService;

    public function __construct(
        StockMovementRepository $movementRepo,
        MovementItemRepository $itemRepo,
        StockItemService $stockService
    ) {
        $this->movementRepo = $movementRepo;
        $this->itemRepo = $itemRepo;
        $this->stockService = $stockService;
    }

    public function getAll()
    {
        return $this->movementRepo->all(['movementItems']);
    }

    public function getById($id)
    {
        return $this->movementRepo->find($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1. Criar movimentação
            $movement = $this->movementRepo->create([
                'type' => $data['type'],
                'movement_date' => $data['movement_date'],
                'user_id' => $data['user_id']
            ]);

            // 2. Criar itens da movimentação
            foreach ($data['itens'] as $item) {
                $this->itemRepo->create([
                    'stock_movement_id'  => $movement->id,
                    'product_id'   => $item['product_id'],
                    'supplier_id'  => $item['supplier_id'],
                    'lot_id'       => $item['lot_id'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
            }

            // 3. Atualizar estoque
            $this->stockService->adjustStockByMovement($data);

            return $movement->load('movementItems');
        });
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {

            // deletar itens primeiro
            $this->itemRepo->deleteByMovement($id);

            // deletar movimentação
            return $this->movementRepo->delete($id);
        });
    }
}
