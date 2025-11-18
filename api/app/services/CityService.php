<?php

namespace App\Services;

use App\Repositories\Eloquent\CityRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getAll()
    {
        return $this->cityRepository->all();
    }

    public function getById($id)
    {
        $city = $this->cityRepository->find($id);

        if (!$city) {
            throw new ModelNotFoundException("City not found.");
        }

        return $city;
    }

    public function create(array $data)
    {
        //validar se o state_id existe
        return $this->cityRepository->create($data);
    }

    public function update($id, array $data)
    {
        $city = $this->cityRepository->find($id);

        if (!$city) {
            throw new ModelNotFoundException("City not found for update.");
        }

        return $this->cityRepository->update($id, $data);
    }

    public function delete($id)
    {
        $city = $this->cityRepository->find($id);

        if (!$city) {
            throw new ModelNotFoundException("City not found for deletion.");
        }

        return $this->cityRepository->delete($id);
    }
}
