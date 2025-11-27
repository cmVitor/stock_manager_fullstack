<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'tipo'  => $this->type,
            'data' => $this->movement_date,
            'funcionarioId' => $this->user,
            'produtoId' => $this->product_id,
            'produto' => $this->product,
            'fornecedorId' => $this->supplier_id,
            'fornecedorNome' => $this->supplier,
            'loteId' => $this->lot_id,
            'loteDescricao' => $this->lot,
            'quantidade' => $this->quantity,
            'preco' => $this->price
        ];
    }
}
