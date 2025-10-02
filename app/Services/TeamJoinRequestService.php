<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamJoinRequest;
use App\Models\InviteJoinRequest;
use Illuminate\Support\Facades\DB;


class TeamJoinRequestService
{

    public function __construct(protected Team $teamModel, protected User $userModel, protected TeamJoinRequest $teamJoinRequestModel, protected InviteJoinRequest $inviteJoinRequestModel) {}

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
            'status' => 'pending'
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

    public function createInviteJoinRequest(Team $team, User $user)
    {

        DB::transaction(function () use ($team, $user) {
            if ($this->inviteJoinRequestModel->where('team_id', $team->id)
                ->where('invite_to_id', $user->id)
                ->where('invite_by_id', $team->owner_id)
                ->where('status', 'pending')
                ->exists()
            ) {
                throw new \Exception('Você já convidou este jogador para este time.');
            }


            if ($team->owner_id === $user->id) {
                throw new \Exception('Você não pode se convidar para o seu próprio time.');
            }


            return $this->inviteJoinRequestModel->create([
                'team_id' => $team->id,
                'invite_to_id' => $user->id,
                'invite_by_id' => $team->owner_id,
                'status' => 'pending'
            ]);
        });
    }
}
