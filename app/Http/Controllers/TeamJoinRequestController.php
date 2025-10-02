<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamJoinRequest;
use App\Models\Notification;
use App\Services\TeamJoinRequestService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TeamJoinRequestController extends Controller
{


    private TeamJoinRequestService $teamJoinRequestService;
    private User $user;

    public function __construct(TeamJoinRequestService $teamJoinRequestService)
    {
        $this->teamJoinRequestService = $teamJoinRequestService;
        $this->user = Auth::User();
    }


    public function index()
    {
        $teams = Team::where('owner_id', $this->user->id)->get();
        $teamId = $teams->pluck('id');

        $joinRequests = TeamJoinRequest::whereIn('team_id', $teamId)->where('status', 'pending')->with(['user', 'team'])->get();
        return view('teams.manage', compact('teams', 'joinRequests'));
    }

    public function requestJoinTeam(Team $team): RedirectResponse
    {

        /*
        Por enquanto manterei desabilitado até eu pensar em como fazer a notificação funcionar..

                $this->notification->create([
            'user_id' => $team->owner_id,
            'actor_id' => $this->userId,
            'team_id' => $team->id,
            'type' => 'join_request',
            'message' => 'Você tem um novo pedido de entrada para o time ' . $team->name,
        ]);
        */

        try {
            $this->teamJoinRequestService->createJoinRequest($team, $this->user);
            return redirect()->route('teams.index')
                ->with('success', 'Pedido de entrada enviado. Aguarde aprovação do dono do time.');
        } catch (Exception $e) {
            return redirect()->route('teams.index')
                ->with('error', 'Erro ao enviar pedido de entrada: ' . $e->getMessage());
        }
    }

    public function responseJoinRequest(Request $request, TeamJoinRequest $joinRequest): RedirectResponse
    {


        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ], [
            'status.required' => 'O status é obrigatório',
            'status.in' => 'O status deve ser approved ou rejected',
        ]);



        try {

            if ($this->user->id !== $joinRequest->team->owner_id) {
                throw new Exception('Você não tem permissão para responder a esse pedido de entrada.');
            }
            $this->teamJoinRequestService->responseJoinRequest($joinRequest, $validated['status']);

            /*
        Por enquanto manterei desabilitado até eu pensar em como fazer a notificação funcionar..

                $this->notification->create([
            'user_id' => $team->owner_id,
            'actor_id' => $this->userId,
            'team_id' => $team->id,
            'type' => 'join_request',
            'message' => 'Você tem um novo pedido de entrada para o time ' . $team->name,
        ]);
        */

            return redirect()->route('manage', status: 302)->with('success', 'Pedido de entrada respondido com sucesso');
        } catch (Exception $e) {
            return redirect()->route('manage', status: 302)->with('error', 'Erro ao responder pedido de entrada: ' . $e->getMessage());
        }
    }

    public function invitePlayerToTeam(Request $request, Team $team): RedirectResponse
    {

        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
            ], [
                'user_id.required' => 'O ID do jogador é obrigatório',
                'user_id.exists' => 'O jogador não existe',
            ]);
            $user = User::find($validated['user_id']);
            $this->teamJoinRequestService->createInviteJoinRequest($team, $user);
            return redirect()->route('teams.index')->with('success', 'Jogador convidado para o time com sucesso');
        } catch (Exception $e) {
            return redirect()->route('teams.index')->with('error', 'Erro ao convidar jogador para o time: ' . $e->getMessage());
        }
    }
}
