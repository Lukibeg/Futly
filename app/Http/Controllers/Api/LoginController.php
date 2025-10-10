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

        // 1. Tenta autenticar o usuário com as credenciais validadas.
        if (!Auth::attempt($validated)) {
            // Se a autenticação falhar, retorna um erro 401 padronizado.
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }

        // 2. Se a autenticação for bem-sucedida, busca o usuário no banco.
        //    Esta é a etapa crucial que estava faltando.
        $user = User::where('name', $request->name)->firstOrFail();

        // 3. Agora com o objeto $user, você pode criar o token.
        // É uma boa prática dar um nome ao token (ex: nome do dispositivo).

        // 4. Apagamos tokens gerados anteriormente e definimos um tempo de expiração de 1 hora.
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', expiresAt: now()->addHour())->plainTextToken;

        // 4. Retorna o token para o cliente.
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function apiShow()
    {
        http_response_code(200);
        return json_encode(['teste' => 'Retornado']);
    }
}
