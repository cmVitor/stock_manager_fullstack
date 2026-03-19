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

        $this->supplierRepository->delete($id);
        return ['message' => 'Fornecedor removido com sucesso.'];
    }


    public function getSupplierDetails()
    {
        $suppliers = $this->supplierRepository->getAll(['address.city.state']);

        return $suppliers->map(function ($supplier) {
            return [
                'id' => $supplier->id,
                'nome' => $supplier->name,
                'contato' => $supplier->phone,
                'email' => $supplier->email,
                'cidade' => $supplier->address->city->name ?? null,
                'cidade_id' => $supplier->address->city->id ?? null,
                'estado' => $supplier->address->city->state->name ?? null,
                'bairro' => $supplier->address->bairro ?? null,
                'cep' => $supplier->address->cep ?? null,
                'logradouro' => $supplier->address->logradouro ?? null,
                'numero' => $supplier->address->number ?? null
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

    public function updateSupplierWithAddress(int $supplierId, array $data)
    {
        try {
            return DB::transaction(function () use ($supplierId, $data) {

                // 1. Busca o fornecedor
                $supplier = $this->supplierRepository->find($supplierId);
                if (!$supplier) {
                    throw new Exception("Fornecedor não encontrado.");
                }

                // 2. Busca o endereço vinculado
                $address = $this->addressRepository->find($supplier->address_id);
                if (!$address) {
                    throw new Exception("Endereço do fornecedor não encontrado.");
                }

                // 3. Atualiza o endereço (se os dados vierem no request)
                $address->update([
                    'logradouro'  => $data['logradouro']  ?? $address->logradouro,
                    'number'      => $data['numero']      ?? $address->number,
                    'complemento' => $data['complemento'] ?? $address->complemento,
                    'city_id'     => $data['cidade_id']     ?? $address->city_id,
                    'bairro'      => $data['bairro']      ?? $address->bairro,
                    'cep'         => $data['cep']         ?? $address->cep,
                ]);

                // 4. Atualiza o fornecedor
                $supplier->update([
                    'name'   => $data['nome']  ?? $supplier->name,
                    'phone'  => $data['contato'] ?? $supplier->phone,
                    'email'  => $data['email'] ?? $supplier->email,
                ]);

                return $supplier->load('address.city.state');
            });
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar fornecedor: " . $e->getMessage());
        }
    }
}
