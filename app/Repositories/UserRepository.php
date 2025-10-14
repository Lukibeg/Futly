<?php

namespace App\Repositories;

use App\Repositories\Interface\UserRepositoryInterface;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function patchUserInterface(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function deleteUserInterface(User $user, int $data)
    {
        $user->delete();
        return $user;
    }

    public function showAvaliableUserInterface()
    {
        $users = User::select('id', 'name')
            ->whereNull('team_id')
            ->get();

        $keyedUsers = $users->mapWithKeys(function ($user) {
            return ['user' . $user->id => $user];
        });

        return $keyedUsers;
    }
}
