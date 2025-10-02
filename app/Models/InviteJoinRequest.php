<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteJoinRequest extends Model
{
    protected $fillable = ['invite_by_id', 'team_id', 'invite_to_id', 'status'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inviteBy()
    {
        return $this->belongsTo(User::class, 'invite_by_id');
    }
}
