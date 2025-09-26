<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class P3hUser extends Model
{
    use HasUuids;
    protected $table = 'p3h_user';
    protected $primaryKey = 'uuid';
    protected $guarded = ['id'];
}
