<?php

namespace App\Services;

use App\Repositories\Eloquent\AddressRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressService
{
    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAll()
    {
        return $this->addressRepository->getAll();
    }

    public function getById($id)
    {
        $address = $this->addressRepository->getById($id);

        if (!$address) {
            throw new ModelNotFoundException("Address not found.");
        }

        return $address;
    }

    public function create(array $data)
    {
        // TODO: validar se city_id existe
        return $this->addressRepository->create($data);
    }

    public function update($id, array $data)
    {
        $address = $this->addressRepository->getById($id);

        if (!$address) {
            throw new ModelNotFoundException("Address not found for update.");
        }

        return $this->addressRepository->update($id, $data);
    }

    public function delete($id)
    {
        $address = $this->addressRepository->getById($id);

        if (!$address) {
            throw new ModelNotFoundException("Address not found for deletion.");
        }

        if ($this->addressRepository->lots()->exists()) {
             throw new Exception("Não é possível excluir um endereço que possui usuarios associados.");
        }

        return $this->addressRepository->delete($id);
    }
}
