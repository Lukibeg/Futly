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
        $teams = Team::with('owner')->get();
        $capacity = 5;
        $membersCount = Team::select('members')->get();
        $members = $membersCount->pluck('members')->all();
        $membersQuantity = count(isset($members[0]) ? $members[0] : []);


        if ($teams->isEmpty()) {
            return redirect()->route('teams.create')->with('error', 'Não há times cadastrados');
        }

        return view('teams.index', ['teams' => $teams, 'membersQuantity' => $membersQuantity]);
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
        return 'Found team';
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
