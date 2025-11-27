<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            'nome' => $this->name,
            'codigo' => $this->code,
            'quantidadeMinima' => $this->min_quantity,
            'perecivel' => $this->perishable,
            'informacaoNutricional' => $this->nutrition_facts,
            'unidadeMedida' => $this->unit_id,
            'categoria' => $this->category_id,
            'marca' => $this->brand_id
        ];
    }
}
