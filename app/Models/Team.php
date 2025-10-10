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

    /** @return HasMany<\Spatie\Permission\Models\Role, self> */

    // public function userTeams(): HasMany
    // {
    //     return $this->hasMany(User::class);
    // }

    public function team(): HasMany
    {
        return $this->hasMany(\Spatie\Permission\Models\Role::class);
    }


    /** @return HasMany<\App\Models\User, self> */
    public function users(): HasMany
    {
        return $this->hasMany(\App\Models\User::class);
    }


    /** @return HasMany<\Spatie\Permission\Models\Role, self> */
    public function roles(): HasMany
    {
        return $this->hasMany(\Spatie\Permission\Models\Role::class);
    }
}
