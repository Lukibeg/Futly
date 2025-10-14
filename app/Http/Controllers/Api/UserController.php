<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function getAvaliablePlayers(Request $request)
    {
        try {
            $avaliableUsers = $this->userService->showAvaliableUserData();
            return response()->json(['success' => $avaliableUsers], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    public function update(Request $request, User $user)
    {
        $authUser = $request->user()->id;

        $validated = $request->validate([
            'birthdate' => 'date',
            'position' => 'string|max:255',
            'about_me' => 'string',
            'strengths' => 'string',
            'weaknesses' => 'string',
            'preferred_foot' => 'string|max:255',
            'height' => 'numeric',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
        ]);

        try {
            $userUpdated = $this->userService->patchUserData($user, $validated, $authUser);

            return response()->json(['message' => 'Dados atualizados com sucesso!', 'user' => $userUpdated], status: 200);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    public function delete(Request $request, User $user)
    {
        $authenticatedUser = $request->user()->id;
        try {
            $userDeleted = $this->userService->deleteUserData($user, $authenticatedUser);
            return response()->json(['message' => 'Usuário deletado com sucesso!', 'user' => $userDeleted], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
