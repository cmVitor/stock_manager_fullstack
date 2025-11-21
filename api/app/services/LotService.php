<?php

namespace App\Services;

use App\Repositories\Eloquent\LotRepository;
use App\Repositories\Eloquent\DepositLocationRepository;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    //GET lotes com a localização do deposito
    public function getAll()
    {
        return $this->lotRepository->with(['depositLocation'])->get();
    }

    public function getById(int $id)
    {
        return $this->lotRepository->with(['depositLocation'])->find($id);
    }

    public function create(array $data)
    {
        $description = trim($data['description'] ?? '');
        $expiration = $data['expiration_date'] ?? null;
        $depositId  = $data['deposit_location_id'] ?? null;

        if (!$description) {
            throw new Exception('Description is required.');
        }

        if (!$expiration) {
            throw new Exception('Expiration date is required.');
        }

        if (Carbon::parse($expiration)->lt(Carbon::today())) {
            throw new Exception('Expiration date cannot be in the past.');
        }

        $deposit = $this->depositRepository->find($depositId);
        if (!$deposit) {
            throw new Exception('Deposit location not found.');
        }

        return $this->lotRepository->create([
            'description' => $description,
            'expiration_date' => $expiration,
            'deposit_location_id' => $depositId,
        ]);
    }

    public function update(int $id, array $data)
    {
        $lot = $this->lotRepository->find($id);
        if (!$lot) {
            throw new Exception('Lot not found.');
        }

        $description = trim($data['description'] ?? $lot->description);
        $expiration  = $data['expiration_date'] ?? $lot->expiration_date;
        $depositId   = $data['deposit_location_id'] ?? $lot->deposit_location_id;


        if (Carbon::parse($expiration)->lt(Carbon::today())) {
            throw new Exception('Expiration date cannot be in the past.');
        }

        $deposit = $this->depositRepository->find($depositId);
        if (!$deposit) {
            throw new Exception('Deposit location not found.');
        }

        return $this->lotRepository->update($id, [
            'description' => $description,
            'expiration_date' => $expiration,
            'deposit_location_id' => $depositId,
        ]);
    }

    public function delete(int $id)
    {
        $lot = $this->lotRepository->find($id);
        if (!$lot) {
            throw new Exception('Lot not found.');
        }

        //Futuramente deve ter uma validação se existe algum StockMovement com esse lote
        return $this->lotRepository->delete($id);
    }

    public function getLotDetails()
    {
        $lots = $this->lotRepository->with(['depositLocation'])->get();

        return $lots->map(function ($lot) {
            return [
                'id' => $lot->id,
                'description' => $lot->description,
                'expiration_date' => $lot->expiration_date,
                'aisle' => $lot->depositLocation->aisle,
                'shelf' => $lot->depositLocation->shelf,
                'section' => $lot->depositLocation->section ?? null,
            ];
        });
    }

    public function createLotWithLocation(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                // Primeiro, cria a deposit_location
                $depositLocation = $this->depositRepository->create([
                    'aisle' => $data['corredor'],
                    'shelf' => $data['prateleira'],
                    'section' => $data['secao'],
                ]);

                // Depois, cria o lote com o deposit_location_id
                $lot = $this->lotRepository->create([
                    'description' => $data['descricao'],
                    'expiration_date' => $data['dataValidade'],
                    'deposit_location_id' => $depositLocation->id,
                ]);

                return $lot;
            });
        } catch (Exception $e) {
            throw new Exception('Erro ao criar lote: ' . $e->getMessage());
        }
    }
}
