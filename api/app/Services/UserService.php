<?php

namespace App\Services;

use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;
    protected $addressRepository;

    public function __construct(UserRepository $userRepository, AddressRepository $addressRepository)
    {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
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
                'nome' => $user->name,
                'cpf' => $user->cpf,
                'email' => $user->email,
                'cargo' => $user->role,
                'cidade' => $user->address->city->name ?? null,
                'cidade_id' => $user->address->city->id,
                'estado' => $user->address->city->state->name ?? null,
                'estado_uf' => $user->address->city->state->uf ?? null,
                'bairro' => $user->address->bairro ?? null,
                'cep' => $user->address->cep ?? null,
                'logradouro' => $user->address->logradouro ?? null,
                'numero' => $user->address->number ?? null,
                'complemento' => $user->address->complemento ?? null
            ];
        });
    }

    public function update($id, array $data)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new ModelNotFoundException("Usuário não encontrado");
        }

        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new ModelNotFoundException("Usuário não encontrado");
        }

        $this->userRepository->delete($id);
        return ['message' => 'Usuario removido com sucesso.'];
    }

    public function updateUserWithAddress(int $userId, array $data)
    {
        try {
            return DB::transaction(function () use ($userId, $data) {

                // 1. Busca o usuario
                $user = $this->userRepository->find($userId);
                if (!$user) {
                    throw new Exception("Usuario não encontrado.");
                }

                // 2. Busca o endereço vinculado
                $address = $this->addressRepository->find($user->address_id);
                if (!$address) {
                    throw new Exception("Endereço do usuario não encontrado.");
                }

                // 3. Atualiza o endereço (se os dados vierem no request)
                $address->update([
                    'logradouro'  => $data['logradouro']  ?? $address->logradouro,
                    'number'      => $data['numero']      ?? $address->number,
                    'complemento' => $data['complemento'] ?? $address->complemento,
                    'city_id'     => $data['cidade_id']     ?? $address->city_id,
                    'bairro'      => $data['bairro']      ?? $address->bairro,
                    'cep'         => $data['cep']         ?? $address->cep,
                ]);

                // 4. Atualiza o usuario
                $user->update([
                    'name'   => $data['nome']  ?? $user->name,
                    'cpf'  => $data['cpf'] ?? $user->cpf,
                    'email'  => $data['email'] ?? $user->email,
                    'role' => $data['cargo'] ?? $user->role
                ]);

                return $user->load('address.city.state');
            });
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar usuario: " . $e->getMessage());
        }
    }
}
