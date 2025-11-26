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

    public function getById($id)
    {
        $product = $this->productRepository->find($id);

        if(!$product) {
            throw new ModelNotFoundException("Produto não encontrado");
        }

        return $product;    
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

        $this->productRepository->delete($id);
        return ['message' => 'Produto removido com sucesso.'];
    }

    public function getProductDetails()
    {
        $products = $this->productRepository->with(['brand', 'category', 'unit'])->get();

        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'nome' => $product->name,
                'codigo' => $product->code,
                'quantidadeMinima' => $product->min_quantity,
                'perecivel' => $product->perishable,
                'informacaoNutricional' => $product->nutrition_facts,
                'unidadeMedida' => $product->unit->name,
                'categoria' => $product->category->name,
                'marca' => $product->brand->name,
            ];
        });
    }

}
