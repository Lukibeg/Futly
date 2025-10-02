<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\DB;

class TeamService
{
    protected $repositoryInterface;

    public function __construct(RepositoryInterface $repositoryInterface)
    {
        $this->repositoryInterface = $repositoryInterface;
    }

    public function createTeam(array $data)
    {
        $userOwner = $this->repositoryInterface->findUserById($data['owner_id']);

        if ($userOwner->team_id !== null) {
            throw new \Exception('Você já faz parte de um time!');
        }

        if (!$userOwner) {
            throw new \Exception('O usuário dono não existe.');
        }

        $members = $data['members'] ?? [];
        $members[] = $data['owener_id'];
        $members = array_unique($members);

        if ($this->repositoryInterface->checkIfUsersAreInTeam($members)) {
            throw new \Exception('Um ou mais usuários já está em um time.');
        }

        return $this->repositoryInterface->createTeam($data);
    }

    public function leaveTeam(Team $team, User $user)
    {

        if ($user->owner_id === $user->id) {
            throw new \Exception('O dono não pode sair do time. Você pode apagar o time ou transferir a propriedade.');
        }

        if (!in_array($user->id, $team->members)) {
            throw new \Exception('Você não é membro deste time.');
        }

        $this->repositoryInterface->leaveTeam($team, $user);
    }
}
