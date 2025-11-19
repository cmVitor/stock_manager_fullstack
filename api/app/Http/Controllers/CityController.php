<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function getCitiesByUf($uf)
    {
        $cities = $this->cityService->getByUf($uf);
        return response()->json($cities);
    }
}
