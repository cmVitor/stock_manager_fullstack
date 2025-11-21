<?php

namespace App\Services;

use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\SupplierRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    protected $supplierRepository;
    protected $addressRepository;

    public function __construct(SupplierRepository $supplierRepository, AddressRepository $addressRepository)
    {
        $this->supplierRepository = $supplierRepository;
        $this->addressRepository = $addressRepository;
    }

    public function getAll()
    {
        return $this->supplierRepository->getAll(['address.city.state']);
    }

    public function getById($id)
    {
        $supplier = $this->supplierRepository->find($id, ['address.city.state']);

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
        $supplier = $this->supplierRepository->find($id);

        if (!$supplier) {
            throw new ModelNotFoundException("Supplier not found for update.");
        }

        return $this->supplierRepository->update($id, $data);
    }

    public function delete($id)
    {
        $supplier = $this->supplierRepository->find($id);

        if (!$supplier) {
            throw new ModelNotFoundException("Supplier not found for deletion.");
        }

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

    public function createSupplierWithAddress(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                // Primeiro, cria o address
                $address = $this->addressRepository->create([
                    'logradouro' => $data['logradouro'],
                    'number' => $data['number'],
                    'complemento' => $data['complemento'],
                    'city_id' => $data['city_id'],
                    'bairro' => $data['bairro'],
                    'cep' => $data['cep'],
                ]);

                // Depois, cria o supplier com o address_id
                $supplier = $this->supplierRepository->create([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'address_id' => $address->id,
                ]);

                return $supplier;
            });
        } catch (Exception $e) {
            throw new Exception('Erro ao criar fornecedor: ' . $e->getMessage());
        }
    }
}
