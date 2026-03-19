<?php

namespace App\Services;

use App\Models\StockMovement;
use App\Repositories\Eloquent\StockMovementRepository;
use App\Repositories\Eloquent\MovementItemRepository;
use App\Services\StockItemService;
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
                'movement_type' => $data['tipo'],
                'movement_date' => $data['data'],
                'user_id' => $data['funcionarioId']
            ]);

            // 2. Criar itens da movimentação
            foreach ($data['itens'] as $item) {
                $this->itemRepo->create([
                    'stock_movement_id'  => $movement->id,
                    'product_id'   => $item['produtoId'],
                    'supplier_id'  => $item['fornecedorId'],
                    'lot_id'       => $item['loteId'],
                    'quantity'     => $item['quantidade'],
                    'price'        => $item['preco'],
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

    public function getAllMovementsWithItems()
    {
        // Carrega todas as movimentações com seus relacionamentos
        $movements = $this->movementRepo->getAll([
            'user',
            'movementItems.product',
            'movementItems.supplier',
            'movementItems.lot'
        ]);

        // Mapeia e formata cada movimentação
        return $movements->map(function ($movement) {

            $formattedItems = $movement->movementItems->map(function ($item) {
                return [
                    'produtoId' => $item->product->id ?? null,
                    'produtoNome' => $item->product->name,
                    'fornecedorId' => $item->supplier->id ?? null,
                    'fornecedorNome' => $item->supplier->name,
                    'loteId' => $item->lot->id ?? null,
                    'loteDescricao' => $item->lot->description,
                    'quantidade' => $item->quantity,
                    'preco' => $item->price,
                ];
            });

            return [
                'id' => $movement->id,
                'tipo' => $movement->movement_type,
                'data' => $movement->movement_date,
                'funcionarioId' => $movement->user->id ?? null,
                'itens' => $formattedItems,
            ];
        });
    }
}
