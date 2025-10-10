<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function __construct() {}


    // public function patchUserData(User $user, array $data, int $authUser)
    // {

    //     if ($user->id !== $authUser) {
    //         throw new \Exception('Você não possui permissão para realizar essa ação');
    //     }

    //     $this->userRepository->patch($user, $data);
    // }

    public function patch(User $user, array $data)
    {
        // O método update() do Eloquent já retorna true ou false.
        $user->update($data);
        return $user; // Retorna o usuário atualizado
    }
}
