<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    protected $guarded = [];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    protected static function booted(): void
    {
        static::addGlobalScope('team', function (Builder $query) {
            if (auth()->hasUser()) {
                // $query->where('team_id', auth()->user()->team_id);
                // or with a `team` relationship defined:
                $query->whereBelongsTo(auth()->user()->teams);
            }
        });
    }
}
