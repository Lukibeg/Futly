<?php

namespace App\Services;

use App\Repositories\Interface\TeamRepositoryInterface;


use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TeamService
{
    public function __construct(protected TeamRepositoryInterface $repositoryInterface) {}
    public function showTeam(Team $team)
    {
        if (!$team) {
            throw new \Exception('ID do time inválido ou time inexistente.', 404);
        }

        return $this->repositoryInterface->showTeam($team);
    }

    public function listTeam(?Team $team)
    {

        $teams = null;

        if (!$team) {
            $teams = $this->repositoryInterface->listAllTeam();
        } else {
            $teams = $this->repositoryInterface->selectTeamsWhereIsDifferentOfMyTeam($team);
        }

        if ($teams->isEmpty()) {
            throw new \Exception('Nenhum time cadastrado. Cadastre o seu agora mesmo!', 302);
        }

        return $teams;
    }
    public function createTeam(array $data)
    {
        $members = [];
        $authenticadedUserId = Auth::user()->id;
        $userOwner = $this->repositoryInterface->findUserById($data['owner_id']);

        if ($authenticadedUserId !== $userOwner->id) {
            throw new \Exception('Você não pode criar um time para outro usuário.', 403);
        }

        if ($userOwner->team_id !== null) {
            throw new \Exception('Você já faz parte de um time!', 403);
        }

        if (!$userOwner) {
            throw new \Exception('O usuário dono não existe.', 403);
        }

        if (isset($data['nomembers']) && !isset($data['members'])) {
            $members[] = json_encode($data['owner_id']);
            $members = array_unique($members);
            $data['members'] = $members;
        }

        $members = $data['members'] ?? [];
        $members[] = $data['owner_id'];
        $members = array_unique($members);

        foreach ($members as $memberKey => $memberValue) {
            $members[] = json_encode($memberValue);
            unset($members[$memberKey]);
        }

        $members = array_values($members);

        $data['members'] = $members;

        if (!isset($data['nomembers']) && !isset($data['members'])) {
            throw new \Exception('Nenhum usuário selecionado, parâmetros nomembers é false.', 403);
        }

        if ($this->repositoryInterface->checkIfUsersAreInTeam($members)) {
            throw new \Exception('Um ou mais usuários já está em um time.', 403);
        }

        return $this->repositoryInterface->createTeam($data);
    }

    public function leaveTeam(Team $team, User $user)
    {

        if ($user->owner_id === $user->id) {
            throw new \Exception('O dono não pode sair do time. Você pode apagar o time ou transferir a propriedade.', 403);
        }

        if (!in_array($user->id, $team->members)) {
            throw new \Exception('Você não é membro deste time.', 403);
        }

        $this->repositoryInterface->leaveTeam($team, $user);
    }
}
