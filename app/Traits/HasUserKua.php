<?php

namespace App\Traits;

use App\Models\KuaUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUserKua
{
    public function kua(): BelongsTo
    {
        return $this->belongsTo(KuaUser::class);
    }
}
