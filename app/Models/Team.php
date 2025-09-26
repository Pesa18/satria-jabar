<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $guarded = ['id'];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function userTeams(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'team_user');
    }
}
