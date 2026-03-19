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
            throw new ModelNotFoundException("Cidade não encontrada");
        }

        return $city;
    }

    public function getByUf($uf)
    {
        $cities = $this->cityRepository->getByUf($uf);

        if($cities->isEmpty()) {
            throw new ModelNotFoundException("Não foi encontrado cidades com esse uf");
        }

        return $cities;
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
            throw new ModelNotFoundException("Cidade não encontrada");
        }

        return $this->cityRepository->update($id, $data);
    }

    public function delete($id)
    {
        $city = $this->cityRepository->find($id);

        if (!$city) {
            throw new ModelNotFoundException("Cidade não encontrada");
        }

        return $this->cityRepository->delete($id);
    }
}
