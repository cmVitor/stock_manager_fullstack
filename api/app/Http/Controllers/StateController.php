<?php

namespace App\Http\Controllers;

use App\Services\StateService;
use Illuminate\Http\Request;

class StateController extends Controller
{
    protected $stateService;

    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    public function index()
    {
        $states = $this->stateService->getAll();
        return response()->json($states);
    }
}
