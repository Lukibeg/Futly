<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request): RedirectResponse
    {

        $validated = $request->validate(
            [
                'name' => 'bail|required|string|max:120',
                'password' => 'bail|required|string|min:8'
            ],
            [
                'name.required' => 'O nome é obrigatório',
                'name.name' => 'O nome precisa ser informado',
                'password.required' => 'A senha é obrigatória',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres',
            ]
        );

        try {

            if (!Auth::attempt($validated)) {
                return redirect()->route('login')->with('error', 'Login ou senha inválidos')->withInput($validated);
            }

            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Erro no servidor: ' . $e->getMessage());
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();

        return redirect()->route('login')->with('success', 'Logout realizado com sucesso');
    }
}
