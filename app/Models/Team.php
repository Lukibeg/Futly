<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Team extends Model
{
    protected $fillable = ['name', 'members', 'capacity', 'owner_id'];


    public function casts()
    {
        return [
            'members' => 'array',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->hasMany(User::class, 'team_id');
    }
    public function addMember(int $userId): void
    {
        $members = $this->members;
        if (!in_array($userId, $members)) {
            $members[] = json_encode($userId);
            $this->members = $members;
            $this->save();
        }
    }
}
