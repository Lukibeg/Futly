<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamService
{

    protected $teamModel;
    protected $userModel;

    public function __construct(Team $teamModel, User $userModel)
    {
        $this->teamModel = $teamModel;
        $this->userModel = $userModel;
    }

    public function createTeam(array $data)
    {
        DB::transaction(function () use ($data) {
            $user = $this->userModel;
            $userOwner = $user->findOrFail($data['owner_id']);
            $members = [];

            if ($userOwner->team_id !== null) {
                throw new \Exception('Você já faz parte de um time!');
            }


            if (!isset($data['members'])) {
                $data['members'] = $members;
            } else {
                $members = $data['members'];
            }

            $members[] = $data['owner_id'];
            $members = array_unique($members);


            $existingMembers = $user->whereIn('id', $members)->whereNotNull('team_id')->exists();

            if ($existingMembers) {
                throw new \Exception('Um ou mais usuários já está em um time.');
            }


            $data['members'] = $members;
            $team = $this->teamModel->create($data);
            $user->whereIn('id', $members)->update(['team_id' => $team->id]);

            return $team;
        });
    }

    public function leaveTeam(Team $team, User $user): void
    {
        // 1. REGRA DE NEGÓCIO: O dono não pode abandonar o time.
        if ($team->owner_id === $user->id) {
            throw new \Exception('O dono não pode sair do time. Você pode apagar o time ou transferir a propriedade.');
        }

        // 2. REGRA DE NEGÓCIO: O usuário deve ser membro do time para poder sair.
        if (!in_array($user->id, $team->members)) {
            dd($user->id);
            throw new \Exception('Você não é membro deste time.');
        }

        DB::transaction(function () use ($team, $user) {
            $newMembers = array_values(array_diff($team->members, [$user->id]));

            $user->team_id = null;
            $user->save();

            if (empty($newMembers)) {
                $team->delete();
            } else {
                $team->members = $newMembers;
                $team->save();
            }
        });
    }
}
