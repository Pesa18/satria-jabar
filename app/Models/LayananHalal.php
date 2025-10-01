<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class LayananHalal extends Model
{
    use HasUuids, Notifiable;
    protected $guarded = ['id'];
    protected $primaryKey = 'uuid';

    protected static function booted()
    {
        static::creating(function ($service) {
            $bulanTahun = now()->format('mY'); // contoh: 092025

            $count = self::where('no_layanan', 'like', '%' . $bulanTahun)->count();

            // Nomor urut dari id (padded 4 digit)
            $urut = str_pad($count + 1, 4, '0', STR_PAD_LEFT);

            // Update field no_layanan
            $service->no_layanan = 'HL' . $urut . $bulanTahun;
        });
    }

    public function status()
    {
        return $this->hasOne(StatusLayanan::class, 'id', 'status_layanan_id');
    }
    public function teamSatria()
    {
        return $this->hasOne(TeamSatria::class, 'id', 'team_satria_id');
    }
}
