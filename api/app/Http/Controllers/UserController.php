<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getUserDetails();
        return response()->json($users);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->userService->update($id, $request->validated());
        return response()->json($user);
    }

    public function destroy($id)
    {
        return response()->json(
            $this->userService->delete($id)
        );
    }
}
