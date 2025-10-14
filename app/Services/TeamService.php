<?php

namespace App\Services;

use App\Repositories\Interface\TeamRepositoryInterface;


use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function __construct(protected TeamRepositoryInterface $repositoryInterface) {}

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
        $userOwner = $this->repositoryInterface->findUserById($data['owner_id']);

        if ($userOwner->team_id !== null) {
            throw new \Exception('Você já faz parte de um time!', 403);
        }

        if (!$userOwner) {
            throw new \Exception('O usuário dono não existe.', 403);
        }

        $members = $data['members'] ?? [];
        $members[] = $data['owner_id'];
        $members = array_unique($members);

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
