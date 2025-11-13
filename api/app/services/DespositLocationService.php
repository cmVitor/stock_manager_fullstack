<?php

namespace App\Services;

use App\Repositories\Eloquent\DepositLocationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class DespositLocationService 
{
    protected $depositLocationRepository;

    public function __construct(DepositLocationRepository $depositLocationRepository)
    {
        $this->depositLocationRepository = $depositLocationRepository;
    }

    public function getAll()
    {
        return $this->depositLocationRepository->getAll();
    }

     public function getById($id)
    {
        $depositLocation = $this->depositLocationRepository->getById($id);

        if (!$depositLocation) {
            throw new ModelNotFoundException("Localização de depósito não encontrada.");
        }

        return $depositLocation;
    }

    public function create(array $data)
    {
        return $this->depositLocationRepository->create($data);
    }

    public function update($id, array $data)
    {
        $depositLocation = $this->depositLocationRepository->getById($id);

        if (!$depositLocation) {
            throw new ModelNotFoundException("Localização de depósito não encontrada para atualização.");
        }

        return $this->depositLocationRepository->update($id, $data);
    }

    public function delete($id)
    {
        $depositLocation = $this->depositLocationRepository->getById($id);

        if (!$depositLocation) {
            throw new ModelNotFoundException("Localização de depósito não encontrada para exclusão.");
        }

         if ($depositLocation->lots()->exists()) {
             throw new Exception("Não é possível excluir uma localização que possui lotes associados.");
        }

        return $this->depositLocationRepository->delete($id);
    }
}