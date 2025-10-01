<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WilayahServices
{

    public function getKabupaten($id = '32'): array
    {
        $cacheKabupaten = Cache::get("provinsi_all_{$id}");
        if (empty($cacheKabupaten)) {
            try {
                $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$id}.json");
                $response->throw();

                $data = $response->json() ?? [];

                // hanya simpan ke cache kalau tidak kosong
                if (!empty($data)) {
                    Cache::put("provinsi_all_{$id}", $data, now()->addHours(24));
                }

                $cacheKabupaten = $data;
            } catch (\Throwable $th) {
                $cacheKabupaten = [];
            }
        }

        return $cacheKabupaten;
    }
    public function getKecamatan($id): array
    {
        $cacheKecamatan = Cache::get("kabupaten_all_{$id}");

        if (empty($cacheKecamatan)) {
            try {
                $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$id}.json");
                $response->throw();

                $data = $response->json() ?? [];

                // hanya simpan ke cache kalau tidak kosong
                if (!empty($data)) {
                    Cache::put("kabupaten_all_{$id}", $data, now()->addHours(24));
                }

                $cacheKecamatan = $data;
            } catch (\Throwable $th) {
                $cacheKecamatan = [];
            }
        }

        return $cacheKecamatan;
    }
    public function getKabupatenName($id)
    {
        try {
            $kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regency/" . $id . ".json")->json();
            return $kabupaten['name'] ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }
    public function getKecamatanName($id)
    {
        try {
            $kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/district/" . $id . ".json")->json();
            return $kabupaten['name'] ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }
}
