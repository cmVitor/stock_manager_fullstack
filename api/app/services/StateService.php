<?php

namespace App\Services;

use App\Repositories\Eloquent\StateRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class StateService
{
    protected $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function getAll()
    {
        return $this->stateRepository->getAll();
    }

    public function getById($id)
    {
        $state = $this->stateRepository->getById($id);

        if (!$state) {
            throw new ModelNotFoundException("State not found.");
        }

        return $state;
    }

    public function create(array $data)
    {
        // validar se a region existe
        return $this->stateRepository->create($data);
    }

    public function update($id, array $data)
    {
        $state = $this->stateRepository->getById($id);

        if (!$state) {
            throw new ModelNotFoundException("State not found for update.");
        }

        return $this->stateRepository->update($id, $data);
    }

    public function delete($id)
    {
        $state = $this->stateRepository->getById($id);

        if (!$state) {
            throw new ModelNotFoundException("State not found for deletion.");
        }

        if ($this->stateRepository->cities()->exists()) {
             throw new Exception("Não é possível excluir um estado que possui cidades associados.");
        }

        return $this->stateRepository->delete($id);
    }
}
