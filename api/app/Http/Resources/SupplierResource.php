<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nome'  => $this->name,
            'contato' => $this->phone,
            'email' => $this->email,
            'cidade' => $this->city,
            'estado' => $this->state,
            'bairro' => $this->bairro
        ];
    }
}
