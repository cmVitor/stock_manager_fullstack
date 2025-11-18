<?php

namespace App\Services;

use App\Repositories\Eloquent\UnitRepository;
use Illuminate\Validation\ValidationException;

class UnitService
{
    protected $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    // Listar todas as unidades
    public function getAll()
    {
        return $this->unitRepository->all();
    }

    // Buscar unidade por ID
    public function getById($id)
    {
        $unit = $this->unitRepository->find($id);

        if (! $unit) {
            throw ValidationException::withMessages([
                'id' => ['Unidade não encontrada.'],
            ]);
        }

        return $unit;
    }

    // Criar nova unidade
    public function create(array $data)
    {
        if (empty($data['name'])) {
            throw ValidationException::withMessages([
                'name' => ['O campo nome é obrigatório.'],
            ]);
        }

        return $this->unitRepository->create($data);
    }

    // Atualizar unidade existente
    public function update($id, array $data)
    {
        $unit = $this->unitRepository->find($id);

        if (! $unit) {
            throw ValidationException::withMessages([
                'id' => ['Unidade não encontrada.'],
            ]);
        }

        return $this->unitRepository->update($id, $data);
    }

    // Deletar unidade
    public function delete($id)
    {
        $unit = $this->unitRepository->find($id);

        if (! $unit) {
            throw ValidationException::withMessages([
                'id' => ['Unidade não encontrada.'],
            ]);
        }

        $this->unitRepository->delete($id);

        return ['message' => 'Unidade removida com sucesso.'];
    }
}
