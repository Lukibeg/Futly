<?php

namespace App\Repositories;

use App\Models\TeamJoinRequest;
use App\Models\User;
use App\Models\Team;


interface TeamJoinRepositoryInterface
{
    public function createTeam(array $data);
    public function leaveTeam(Team $team, User $user);
    public function findUserById(int $id);
    public function checkIfUsersAreInTeam(array $members);
}
