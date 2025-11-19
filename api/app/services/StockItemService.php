<?php

namespace App\Services;

use App\Repositories\Eloquent\StockItemRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\LotRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class StockItemService
{
    protected $stockRepo;
    protected $productRepo;
    protected $lotRepo;

    public function __construct(
        StockItemRepository $stockRepo,
        ProductRepository $productRepo,
        LotRepository $lotRepo
    ) {
        $this->stockRepo = $stockRepo;
        $this->productRepo = $productRepo;
        $this->lotRepo = $lotRepo;
    }

    public function getAll()
    {
        $items = $this->stockRepo->all(['product', 'lot']);

        return $items->map(function ($item) {
            return [
                'id' => $item->id,
                'produtoId' => $item->product_id,
                'produtoNome' => $item->product->name,
                'lote' => $item->lot->description,
                'validade' => $item->lot->expiration_date,
                'saldo' => $item->balance,
                'quantidadeMinima' => $item->product->min_quantity ?? 0
            ];
        });
    }

    public function adjustStockByMovement(array $mov)
    {
        return DB::transaction(function () use ($mov) {

            foreach ($mov['itens'] as $item) {

                // 1. Buscar lote
                $lot = $this->lotRepo->find($item['lot_id']);

                // 2. Procurar item de estoque existente (product + lot)
                $stock = $this->stockRepo->findByProductAndLot(
                    $item['product_id'],
                    $lot->id
                );

                //   VALIDAÇÃO: SAÍDA MAIOR QUE O SALDO
                if ($mov['type'] === 'S') {

                    // Não existe estoque -> não pode sair
                    if (!$stock) {
                        throw new \Exception("Não há estoque para o produto {$item['product_id']} no lote {$lot->id}.");
                    }

                    // Saldo insuficiente -> não pode colocar negativo
                    if ($stock->balance < $item['quantity']) {
                        throw new \Exception(
                            "Saldo insuficiente para o produto {$item['product_id']} no lote {$lot->id}. " .
                                "Saldo atual: {$stock->balance}, solicitado: {$item['quantity']}."
                        );
                    }
                }

                // 3. Se já existe item de estoque, atualizar saldo
                if ($stock) {

                    $novoSaldo = $mov['type'] === 'E'
                        ? $stock->balance + $item['quantity']
                        : $stock->balance - $item['quantity'];

                    $stock->balance = max($novoSaldo, 0);
                    $stock->save();

                    continue;
                }

                // 4. Se ainda NÃO existe estoque e for ENTRADA, criar registro
                if ($mov['type'] === 'E') {

                    $product = $this->productRepo->find($item['product_id']);

                    $this->stockRepo->create([
                        'product_id'      => $item['product_id'],
                        'lot_id'          => $lot->id,
                        'expiration_date' => $lot->expiration_date,
                        'min_quantity'    => $product->min_quantity,
                        'balance'         => $item['quantity'],
                    ]);
                }

                // OBS: Saída sem registro não cria stock_item.
            }
        });
    }

    public function getStockDetails()
    {
        // Carregar estoque + relações necessárias
        $items = $this->stockRepo->all(['product', 'lot']);

        return $items->map(function ($item) {

            $hoje = now();
            $validade = Carbon::parse($item->expiration_date);

            // Diferença em dias (negativo significa expirado)
            $dias = $validade->diffInDays($hoje, false);

            return [
                'id'               => $item->id,
                'product_id'       => $item->product_id,
                'produto_nome'     => $item->product->name ?? null,
                'lote_description' => $item->lot->description ?? null,
                'expiration_date'  => $item->expiration_date,
                'balance'          => $item->balance,
                'min_quantity'     => $item->min_quantity,

                // Cálculos
                'diasParaVencer'   => $dias,
                'expirado'         => $dias < 0,
                'pertoDeVencer'    => $dias >= 0 && $dias <= 30,
                'estoqueCritico'   => $item->balance <= $item->min_quantity,
            ];
        });
    }

    public function delete($id)
    {
        $stock = $this->stockRepo->find($id);

        if (!$stock) {
            throw new ModelNotFoundException("Item de estoque não encontrado para exclusão.");
        }

        return $this->stockRepo->delete($id);
    }
}
