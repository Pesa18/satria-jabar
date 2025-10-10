<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageInfoLayanan extends Model
{
    protected $table = 'message_info_layanan';
    protected $guarded = ['id'];

    public function LayananHalal()
    {
        return $this->belongsTo(LayananHalal::class, 'layanan_halal_id', 'id');
    }
}
