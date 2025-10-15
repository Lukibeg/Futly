<?php

namespace App\Repositories;

use App\Repositories\Interface\TeamRepositoryInterface;

use App\Models\InviteJoinRequest;
use App\Models\TeamJoinRequest;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class TeamEloquentRepository implements TeamRepositoryInterface
{
    public function __construct(protected User $userModel, protected Team $teamModel) {}


    public function showTeam(Team $team)
    {
        return User::select('id', 'name', 'position')->where('team_id', $team->id)->get();
    }
    public function listAllTeam()
    {
        return Team::all();
    }
    public function createTeam(array $data)
    {
        return DB::transaction(function () use ($data) {
            $team = $this->teamModel->create($data);
            $this->userModel->whereIn('id', $data['members'])->update(['team_id' => $team->id]);
            return $team;
        });
    }

    public function leaveTeam($team, $user)
    {
        return DB::transaction(function () use ($team, $user) {

            $user->update(['team_id' => null]);

            $newMembers = array_values(array_diff($team->members, [$user->id]));

            if (empty($newMembers)) {
                $team->delete();
            } else {
                $team->update(['members' => $newMembers]);
            }

            return $team;
        });
    }

    public function findUserById(int $id)
    {
        return $this->userModel->findOrFail($id);
    }

    public function checkIfUsersAreInTeam(array $userIds): bool
    {
        return $this->userModel->whereIn('id', $userIds)->whereNotNull('team_id')->exists();
    }

    public function selectTeamsWhereIsDifferentOfMyTeam(Team $team)
    {
        $query = Team::with('owner');
        return $query->where('id', '!=', $team->id)->get();
    }
}
