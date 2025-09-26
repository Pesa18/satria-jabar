<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LayananMasjid extends Model
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
            $service->no_layanan = 'MD' . $urut . $bulanTahun;
        });
    }
}
