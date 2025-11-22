<?php

namespace App\Services;

use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $userRepository;
    protected $addressRepository;

    public function __construct(UserRepository $userRepository, AddressRepository $addressRepository)
    {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }

   public function register(array $data)
{
    try {
        return DB::transaction(function () use ($data) {

            // Salva a senha em plaintext antes de criptografar
            $plainPassword = $data['password'];

            // 1 — Criar Address
            $address = $this->addressRepository->create([
                'logradouro' => $data['logradouro'],
                'number' => $data['number'],
                'complemento' => $data['complemento'],
                'city_id' => $data['city_id'],
                'bairro' => $data['bairro'],
                'cep' => $data['cep'],
            ]);

            // 2 — Criar Usuário vinculado ao Address
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'cpf' => $data['cpf'],
                'email' => $data['email'],
                'role' => $data['role'],
                'cpf' => $data['cpf'],
                'password' => Hash::make($plainPassword),
                'address_id' => $address->id,
            ]);

            // 3 — Gerar Token JWT
            $token = JWTAuth::attempt([
                'email' => $data['email'],
                'password' => $plainPassword
            ]);

            if (!$token) {
                throw ValidationException::withMessages([
                    'auth' => ['Falha ao gerar token.']
                ]);
            }

            // 4 — Retornar User + Token
            return [
                'user' => $user,
                'token' => $token,
                'address' => $address
            ];
        });

    } catch (Exception $e) {
        throw new Exception('Erro no registro: ' . $e->getMessage());
    }
}

    public function login(array $credentials)
    {
        if (! $token = Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        return $this->respondWithToken($token);
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function logout()
    {
        Auth::logout();
        return ['message' => 'Logout realizado com sucesso'];
    }

    public function refresh()
    {
        $newToken = Auth::refresh();

        // Retorna somente o token
        return [
            'access_token' => $newToken,
        ];
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
