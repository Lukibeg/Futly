<?php

namespace App\Repositories\Interface;

use App\Models\TeamJoinRequest;
use App\Models\InviteJoinRequest;
use App\Models\User;
use App\Models\Team;


interface TeamInviteRepositoryInterface
{
    public function createInviteJoinRequest(User $user, Team $team);
    public function responseJoinRequest(TeamJoinRequest $joinRequest, string $status);
    public function verifyIfPlayerHasConvited(User $user, Team $team);
    public function verifyIfTeamOwnerIdIsEqualUserId(User $user, Team $team);
    public function verifyIfInvitedUserHasTeam(TeamJoinRequest $TeamJoinRequest);
}
