<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request): RedirectResponse
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
            
            if (!User::create($validated)) {
                return redirect()->route('register')->with('error', 'Erro ao criar usuário.');
            }

            return redirect()->route('login')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Erro no servidor: ' . $e->getMessage());
        }
    }
}
