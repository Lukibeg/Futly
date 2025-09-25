<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamJoinRequest;
use Illuminate\Support\Facades\DB;


class TeamJoinRequestService
{

    public function __construct(protected Team $teamModel, protected User $userModel, protected TeamJoinRequest $teamJoinRequestModel) {}

    public function createJoinRequest(Team $team,  User $user): TeamJoinRequest
    {

        if ($this->teamJoinRequestModel->where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists()
        ) {
            throw new \Exception('Você já tem um pedido pendente para esse time.');
        }

        if ($team->owner_id === $user->id) {
            throw new \Exception('Você não pode se juntar a um time que você é o dono.');
        }

        if ($team->id === $user->team_id) {
            throw new \Exception('Você já é membro desse time.');
        }

        if ($user->team_id !== null) {
            throw new \Exception('Você já faz parte de outro time!');
        }

        return $this->teamJoinRequestModel->create([
            'team_id' => $team->id,
            'user_id' => $user->id,
        ]);
    }

    public function responseJoinRequest(TeamJoinRequest $joinRequest, string $status)
    {

        if ($joinRequest->status !== 'pending') {
            throw new \Exception('Este pedido já foi respondido.');
        }

        return DB::transaction(function () use ($joinRequest, $status) {
            $userToJoin = $joinRequest->user;
            $team = $joinRequest->team;

            if ($status === 'approved') {
                if ($userToJoin->team_id !== null) {
                    throw new \Exception("O usuário {$userToJoin->name} já entrou em outro time.");
                }

                $team->addMember($userToJoin->id);
                $userToJoin->update(['team_id' => $team->id]);
            }

            $joinRequest->update(['status' => $status]);

            return $joinRequest;
        });
    }
}
