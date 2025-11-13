<?php

namespace App\Services;

use App\Repositories\Eloquent\SupplierRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAll()
    {
        return $this->supplierRepository->getAll(['address.city.state']);
    }

    public function getById($id)
    {
        $supplier = $this->supplierRepository->getById($id, ['address.city.state']);

        if (!$supplier) {
            throw new ModelNotFoundException("Supplier not found.");
        }

        return $supplier;
    }

    public function create(array $data)
    {
        // TODO: validar se o address_id é válido
        return $this->supplierRepository->create($data);
    }

    public function update($id, array $data)
    {
        $supplier = $this->supplierRepository->getById($id);

        if (!$supplier) {
            throw new ModelNotFoundException("Supplier not found for update.");
        }

        return $this->supplierRepository->update($id, $data);
    }

    public function delete($id)
    {
        $supplier = $this->supplierRepository->getById($id);

        if (!$supplier) {
            throw new ModelNotFoundException("Supplier not found for deletion.");
        }

        // TODO: validar se há movimentações associadas

        return $this->supplierRepository->delete($id);
    }


    public function getSupplierDetails()
    {
        $suppliers = $this->supplierRepository->getAll(['address.city.state']);

        return $suppliers->map(function ($supplier) {
            return [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'phone' => $supplier->phone,
                'email' => $supplier->email,
                'city' => $supplier->address->city->name ?? null,
                'state' => $supplier->address->city->state->name ?? null,
                'bairro' => $supplier->address->bairro ?? null,
            ];
        });
    }
}
