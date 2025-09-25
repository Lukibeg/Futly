<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Team;

class Notification extends Model
{
    protected $fillable = ['user_id', 'actor_id', 'team_id', 'type', 'message', 'read_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
