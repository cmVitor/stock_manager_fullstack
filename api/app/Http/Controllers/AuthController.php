<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function register(UserRequest $request)
    {

            $result = $this->authService->register($request->validated());

            return response()->json([
                'message' => 'Usuário registrado com sucesso.',
                'token' => $result['token'],
                'user' => $result['user'],
                'address' => $result['address']
            ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json($this->authService->getCurrentUser());
    }

    public function logout()
    {
        $result = $this->authService->logout();
        return response()->json($result);
    }

    public function refresh()
    {
        $result = $this->authService->refresh();
        return response()->json($result);
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
