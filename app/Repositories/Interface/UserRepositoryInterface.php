<?php

namespace App\Repositories\Interface;

use App\Models\Team;
use App\Models\User;


interface UserRepositoryInterface
{
    public function patchUserInterface(User $user, array $data);
    public function deleteUserInterface(User $user, int $authenticatedUser);
    public function showAvaliableUserInterface();
}
