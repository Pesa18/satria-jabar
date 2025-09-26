<?php

namespace App\Traits;

use App\Models\P3hUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasUserp3h
{
    public function p3h(): BelongsTo
    {
        return $this->belongsTo(P3hUser::class);
    }
}
