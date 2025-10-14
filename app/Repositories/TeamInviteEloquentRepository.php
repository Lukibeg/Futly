<?php

namespace App\Repositories;
use App\Repositories\Interface\TeamInviteRepositoryInterface;

use App\Models\InviteJoinRequest;
use App\Models\TeamJoinRequest;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class TeamInviteEloquentRepository implements TeamInviteRepositoryInterface
{
    public function __construct(protected InviteJoinRequest $teamInviteJoinRequestModel) {}
    public function createInviteJoinRequest(User $user, Team $team)
    {
        return $this->teamInviteJoinRequestModel->create([
            'team_id' => $team->id,
            'invite_to_id' => $user->id,
            'invite_by_id' => $team->owner_id,
            'status' => 'pending'
        ]);
    }
    public function responseJoinRequest(TeamJoinRequest $joinRequest, string $status)
    {
        $user = $joinRequest->user;
        $team = $joinRequest->team;

        $joinRequest = DB::transaction(function () use ($joinRequest, $status, $user, $team) {
            $team->addMember($user->id);
            $user->update(['team_id' => $team->id]);
            $joinRequest->update(['status' => $status]);
        });

        return $joinRequest;
    }

    public function verifyIfPlayerHasConvited(User $user, Team $team)
    {
        $result = DB::transaction(function () use ($user, $team) {
            return $query = $this->teamInviteJoinRequestModel->where('team_id', $team->id)

                ->where('invite_to_id', $user->id)
                ->where('invite_by_id', $team->owner_id)
                ->where('status', 'pending')
                ->exists();
        });

        return $result;
    }

    public function verifyIfTeamOwnerIdIsEqualUserId(User $user, Team $team)
    {
        return $team->owner_id === $user->id ? true : false;
    }

    public function verifyIfInvitedUserHasTeam(TeamJoinRequest $teamJoinRequest)
    {
        return $teamJoinRequest->user->team_id != null ? true : false;
    }
}
