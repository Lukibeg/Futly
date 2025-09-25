<?php

namespace App\Models;
use App\Models\Team;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class TeamJoinRequest extends Model
{
    protected $fillable = ['team_id', 'user_id', 'status'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
