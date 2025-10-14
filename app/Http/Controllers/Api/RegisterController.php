<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'bail|required|string|max:120',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email deve ser um endereço de email válido',
            'email.unique' => 'O email já está em uso',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres',
            'password_confirmation' => 'A confirmação não corresponde a senha inserida.'
        ]);

        try {

            $user = User::create($validated);

            return response()->json(['success' => 'Usuário criado com sucesso!', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao criar o usuário.', 'error' => $e->getMessage()], $e->getCode());
        }
    }
}
