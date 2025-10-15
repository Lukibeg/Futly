<?php

namespace App\Repositories\Interface;

use App\Models\Team;
use App\Models\User;

interface TeamRepositoryInterface
{
    public function showTeam(Team $team);
    public function createTeam(array $data);
    public function leaveTeam(Team $team, User $user);
    public function findUserById(int $id);
    public function checkIfUsersAreInTeam(array $members);
    public function selectTeamsWhereIsDifferentOfMyTeam(Team $team);
    public function listAllTeam();
}
