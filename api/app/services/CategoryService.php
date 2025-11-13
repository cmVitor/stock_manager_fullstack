<?php

namespace App\Services;

use App\Repositories\Eloquent\CategoryRepository;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
        {
            $this->categoryRepository = $categoryRepository;
        }

    // Listar todas as categorias
    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    // Buscar categoria por ID
    public function getById($id)
    {
        $category = $this->categoryRepository->find($id);

        if (! $category) {
            throw ValidationException::withMessages([
                'id' => ['Categoria não encontrada.'],
            ]);
        }

        return $category;
    }

    // Criar nova categoria
    public function create(array $data)
    {
        if (empty($data['name'])) {
            throw ValidationException::withMessages([
                'name' => ['O campo nome é obrigatório.'],
            ]);
        }

        return $this->categoryRepository->create($data);
    }

    // Atualizar categoria existente
    public function update($id, array $data)
    {
        $category = $this->categoryRepository->find($id);

        if (! $category) {
            throw ValidationException::withMessages([
                'id' => ['Categoria não encontrada.'],
            ]);
        }

        return $this->categoryRepository->update($id, $data);
    }

    // Deletar categoria
    public function delete($id)
    {
        $category = $this->categoryRepository->find($id);

        if (! $category) {
            throw ValidationException::withMessages([
                'id' => ['Categoria não encontrada.'],
            ]);
        }

        $this->categoryRepository->delete($id);

        return ['message' => 'Categoria removida com sucesso.'];
    }
}
