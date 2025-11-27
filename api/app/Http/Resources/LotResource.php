<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
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
            'descricao'  => $this->description,
            'dataValidade' => $this->expiration_date,
            'corredor' => $this->aisle,
            'prateleira' => $this->shelf,
            'secao' => $this->section
        ];
    }
}
