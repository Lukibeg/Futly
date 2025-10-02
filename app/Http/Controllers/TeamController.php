<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Services\TeamService;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    private TeamService $teamService;
    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }
    public function index()
    {
        $myTeam = Auth::user()->team;
        $query = Team::with('owner');

        if ($myTeam) {
            $query->where('id', '!=', $myTeam->id);
        }

        $teams = $query->get();

        if ($teams->isEmpty() && !$myTeam) {
            return redirect()->route('teams.create')->with('error', 'Nenhum time cadastrado. Crie o primeiro!');
        }

        return view('teams.index', [
            'myTeam' => $myTeam,
            'teams' => $teams,
        ]);
    }

    public function create(Request $request): View
    {
        try {
            $users = User::all()->where('team_id', null);
            return view('teams.create', ['users' => $users]);
        } catch (\Exception $e) {
            return view('teams.create')->with('error', 'Erro ao carregar usuários: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'members' => 'array',
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
            $this->teamService->createTeam($validated);
            return redirect()->route('teams.index', status: 302)->with('success', 'Time criado com sucesso. Seu usuário também foi adicionado ao time.');
        } catch (\Exception $e) {
            return redirect()->route('teams.create', status: 302)->with('error', 'Erro ao criar time: ' . $e->getMessage());
        }
    }

    public function show(Team $team)
    {
        $users = User::where('team_id', $team->id)->get();
        return view('teams.users', ['users' => $users, 'team' => $team]);
    }

    public function leaveTeam(Team $team)
    {
        try {
            $this->teamService->leaveTeam($team, Auth::user());
            return redirect()->route('teams.index', status: 302)->with('success', 'Você saiu do time com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('teams.index', status: 302)->with('error', 'Você não faz parte deste time.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
