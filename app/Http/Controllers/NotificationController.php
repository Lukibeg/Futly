<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    private Notification $notification;


    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'actor_id' => 'required|exists:users,id',
            'team_id' => 'required|exists:teams,id',
            'type' => 'required|string',
            'message' => 'required|string',
        ], [
            'user_id.required' => 'O usuário é obrigatório',
            'actor_id.required' => 'A ação é obrigatória',
            'team_id.required' => 'O time é obrigatório',
            'type.required' => 'O tipo é obrigatório',
        ]);

        $this->notification->create($validated);
    }
}
