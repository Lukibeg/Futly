<?php

namespace App\Repositories\Interface;

use App\Models\Team;
use App\Models\User;


interface UserRepositoryInterface
{
    public function patch(User $user, array $data);
}
