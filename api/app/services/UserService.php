<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class userService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll(['address.city.state']);
    }



    public function getUserDetails()
    {
        $users = $this->userRepository->getAll(['address.city.state']);

        return $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'city' => $user->address->city->name ?? null,
                'state' => $user->address->city->state->name ?? null,
                'bairro' => $user->address->bairro ?? null,
            ];
        });
    }
}
