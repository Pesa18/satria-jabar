<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class KuaUser extends Model
{
    use HasUuids;
    protected $table = 'kua_user';
    protected $primaryKey = 'uuid';
    protected $guarded = ['id'];
}
