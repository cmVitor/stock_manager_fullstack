<?php

namespace App\Services;

use App\Repositories\Eloquent\BrandRepository;
use Illuminate\Validation\ValidationException;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    // Listar todas as marcas
    public function getAll()
    {
        return $this->brandRepository->all();
    }

    // Buscar marca por ID
    public function getById($id)
    {
        $brand = $this->brandRepository->find($id);

        if (! $brand) {
            throw ValidationException::withMessages([
                'id' => ['Marca não encontrada.'],
            ]);
        }

        return $brand;
    }

    // Criar nova marca
    public function create(array $data)
    {
        if (empty($data['name'])) {
            throw ValidationException::withMessages([
                'name' => ['O campo nome é obrigatório.'],
            ]);
        }

        return $this->brandRepository->create($data);
    }

    // Atualizar marca existente
    public function update($id, array $data)
    {
        $brand = $this->brandRepository->find($id);

        if (! $brand) {
            throw ValidationException::withMessages([
                'id' => ['Marca não encontrada.'],
            ]);
        }

        return $this->brandRepository->update($id, $data);
    }

    // Deletar marca
    public function delete($id)
    {
        $brand = $this->brandRepository->find($id);

        if (! $brand) {
            throw ValidationException::withMessages([
                'id' => ['Marca não encontrada.'],
            ]);
        }

        $this->brandRepository->delete($id);

        return ['message' => 'Marca removida com sucesso.'];
    }
}
