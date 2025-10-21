<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class TeamController extends Controller
{
    public function __construct(protected TeamService $teamService) {}
    public function index(Request $request)
    {
        try {
            //Using eloquent relations 
            $myTeam = Auth::user()->team;
            $teams = $this->teamService->listTeam($myTeam);

            return response()->json(['message' => 'success', 'myTeam' => $myTeam, 'teams' => $teams]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'members' => 'array',
                'nomembers' => 'bool',
                'members.*' => 'exists:users,id',
                'owner_id' => 'required|exists:users,id'
            ],
            [
                'name.required' => 'O nome é obrigatório',
                'name.string' => 'O nome deve ser uma string',
                'name.max' => 'O nome deve ter no máximo 255 caracteres',
                'members.array' => 'Os membros devem ser um array',
                'members.*.exists' => 'Os membros devem existir no banco de dados',
                'owner_id.required' => 'O líder do time é obrigatório',
                'owner_id.exists' => 'O líder do time deve existir no banco de dados'
            ]
        );

        try {
            $team = $this->teamService->createTeam($validated);
            return response()->json(['message' => 'Time criado com sucesso. Seu usuário também foi adicionado a equipe.', 'team' => $team], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Team $team)
    {
        try {
            $users = $this->teamService->showTeam($team);
            $data = ['team' => $team, 'users' => $users];
            return response()->json(['message' => 'Dados obtidos com sucesso!', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    // public function leaveTeam(Team $team)
    // {
    //     try {
    //         $this->teamService->leaveTeam($team, Auth::user());
    //         return redirect()->route('teams.index', status: 302)->with('success', 'Você saiu do time com sucesso.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('teams.index', status: 302)->with('error', 'Você não faz parte deste time.');
    //     }
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, int $id) {}

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
