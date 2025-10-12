<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepositoryInterface) {}


    public function patchUserData(User $user, array $data, int $authUser)
    {

        if ($user->id !== $authUser) {
            throw new \Exception("Você não possui permissão para realizar essa ação.", 403);
        }

        if (empty($data)) {
            throw new \Exception("Campo informado inválido ou vazio, verifique e tente novamente.", 403);
        }

        return $this->userRepositoryInterface->patch($user, $data);
    }
}
