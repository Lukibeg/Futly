<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\User;

interface TeamRepositoryInterface
{
    public function createTeam(array $data);
    public function leaveTeam(Team $team, User $user);
    public function findUserById(int $id);
    public function checkIfUsersAreInTeam(array $members);
}
