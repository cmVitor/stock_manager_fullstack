<?php

namespace App\Services;

use App\Repositories\Eloquent\LotRepository;
use App\Repositories\Eloquent\DepositLocationRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Exception;
use Carbon\Carbon;

class LotService
{
    protected LotRepository $lotRepository;
    protected DepositLocationRepository $depositRepository;

    public function __construct(
        LotRepository $lotRepository,
        DepositLocationRepository $depositRepository
    ) {
        $this->lotRepository = $lotRepository;
        $this->depositRepository = $depositRepository;
    }

    
    public function getAll()
    {
        return $this->lotRepository->with(['depositLocation'])->get();
    }
}
