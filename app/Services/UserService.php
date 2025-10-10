<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepositoryInterface) {}


    public function patchUserData(User $user, array $data, int $authUser)
    {

        if ($user->id !== $authUser) {
            throw new \Exception(response()->json(['message' => 'Você não possui permissão para realizar essa ação.'], 401));
        }

        return $this->userRepositoryInterface->patch($user, $data);
    }
}
