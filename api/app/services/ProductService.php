<?php

namespace App\Services;

use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll()
    {
        return $this->productRepository->all();
    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new ModelNotFoundException("Produto não encontrado");
        }

        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw new ModelNotFoundException("Produto não encontrado");
        }

        return $this->productRepository->delete($id);
    }

}
