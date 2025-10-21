<?php

namespace App\Services;

use App\Repositories\Interface\TeamInviteRepositoryInterface;


use App\Models\Team;
use App\Models\User;
use App\Models\TeamJoinRequest;
use App\Models\InviteJoinRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeamJoinRequestService
{

    public function __construct(protected Team $teamModel, protected User $userModel, protected TeamJoinRequest $teamJoinRequestModel, protected InviteJoinRequest $inviteJoinRequestModel, protected TeamInviteRepositoryInterface $teamInviteInterfaceRepository) {}

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

        if ($status === 'approved') {
            if ($this->teamInviteInterfaceRepository->verifyIfInvitedUserHasTeam($joinRequest)) {
                throw new \Exception("O usuário {$joinRequest->name} já entrou em outro time.");
            }
        }

        return $this->teamInviteInterfaceRepository->responseJoinRequest($joinRequest, $status);
    }

    public function createInviteJoinRequest(Team $team, User $user)
    {


        $loggedUser = Auth::user();


        if ($loggedUser->team_id == 0) {
            throw new \Exception('Você não possui um time. Para convidar outros usuários para seu time, por favor, crie uma equipe.');
        }

        if ($this->teamInviteInterfaceRepository->verifyIfPlayerHasConvited($user, $team)) {
            throw new \Exception('Você já convidou este usuário para seu time.');
        }

        if ($this->teamInviteInterfaceRepository->verifyIfTeamOwnerIdIsEqualUserId($user, $team)) {
            throw new \Exception('Você não pode se convidar para o seu próprio time.');
        }

        return $this->teamInviteInterfaceRepository->createInviteJoinRequest($user, $team);
    }
}
