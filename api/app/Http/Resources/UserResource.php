<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'cpf' => $this->cpf,
            'email' => $this->email,
            'cargo' => $this->role,
            'cidade' => $this->city,
            'estado' => $this->state,
            'bairro' => $this->bairro
        ];
    }
}
