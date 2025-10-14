<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepositoryInterface) {}

    public function patchUserData(User $user, array $data, int $authenticatedUser)
    {

        if ($user->id !== $authenticatedUser) {
            throw new \Exception("Você não possui permissão para realizar essa ação.", 403);
        }

        if (!$user) {
            throw new \Exception('Usuário inativo ou inexistente.', 404);
        }

        if (empty($data)) {
            throw new \Exception("Campo informado inválido ou vazio, verifique e tente novamente.", 403);
        }

        return $this->userRepositoryInterface->patchUserInterface($user, $data);
    }

    public function deleteUserData(User $user, $authenticatedUser)
    {
        if ($user->id !== $authenticatedUser) {
            throw new \Exception("Você não possui permissão para realizar essa ação.", 403);
        }

        if (!$user) {
            throw new \Exception("Campo informado inválido ou vazio, verifique e tente novamente.", 403);
        }

        return $this->userRepositoryInterface->deleteUserInterface($user, $authenticatedUser);
    }

    public function showAvaliableUserData()
    {
        $users = $this->userRepositoryInterface->showAvaliableUserInterface();

        if (empty($users)) {
            throw new \Exception("Não há usuários sem equipe, mas você pode iniciar uma somente com seu usuário.", 204);
        }

        return $users;
    }
}
