<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LayananKiblat extends Model
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
            $service->no_layanan = 'KL' . $urut . $bulanTahun;
        });
    }
    public function statusLayanan()
    {
        return $this->belongsTo(StatusLayanan::class, 'status_layanan_id');
    }
    public function teamSatria()
    {
        return $this->hasOne(TeamSatria::class, 'id', 'team_satria_id');
    }
    public function MessageInfoLayanan()
    {
        return $this->belongsTo(MessageInfoLayanan::class, 'id', 'layanan_kiblat_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
