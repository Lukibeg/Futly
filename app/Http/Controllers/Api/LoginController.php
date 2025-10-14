<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string',
                'password' => 'required|string'
            ],
            [
                'name.required' => 'O nome de usuário é obrigatório.',
                'password.required' => 'A senha é obrigatória.'
            ]
        );

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        $user = User::where('name', $request->name)->firstOrFail();

        $user->tokens()->delete();
        $token = $user->createToken('auth_token', expiresAt: now()->addHour())->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
