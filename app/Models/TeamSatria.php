<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TeamSatria extends Model
{
    use HasUuids;
    protected $table = 'team_satria';
    protected $primaryKey = 'uuid';
    protected $guarded = [];
    public $timestamps = true;
    public function scopeNearest($query, $latitude, $longitude)
    {
        return $query->selectRaw("
    *,
    (6371 * acos(
        cos(radians(?)) 
        * cos(radians(JSON_UNQUOTE(JSON_EXTRACT(location, '$.lat')))) 
        * cos(radians(JSON_UNQUOTE(JSON_EXTRACT(location, '$.lng'))) - radians(?)) 
        + sin(radians(?)) 
        * sin(radians(JSON_UNQUOTE(JSON_EXTRACT(location, '$.lat'))))
    )) AS distance
", [$latitude, $longitude, $latitude])
            ->orderBy('distance');
    }
}
