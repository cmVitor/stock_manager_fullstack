<?php

namespace App\Services;

use App\Repositories\Eloquent\RegionRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegionService
{
    protected $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function getAll()
    {
        return $this->regionRepository->all();
    }

    public function getById($id)
    {
        $region = $this->regionRepository->find($id);

        if (!$region) {
            throw new ModelNotFoundException("Region not found.");
        }

        return $region;
    }

    public function create(array $data)
    {
        // validar duplicidade de nome
        return $this->regionRepository->create($data);
    }

    public function update($id, array $data)
    {
        $region = $this->regionRepository->find($id);

        if (!$region) {
            throw new ModelNotFoundException("Region not found for update.");
        }

        return $this->regionRepository->update($id, $data);
    }

    public function delete($id)
    {
        $region = $this->regionRepository->find($id);

        if (!$region) {
            throw new ModelNotFoundException("Region not found for deletion.");
        }

        return $this->regionRepository->delete($id);
    }
}
