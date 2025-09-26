<?php

namespace App\Filament\Resources\LayananSatrias\Schemas;

use App\Filament\Forms\Components\LocationPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LayananSatriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lokasi Layanan Satria')
                    ->description('Pilih lokasi layanan Satria Anda pada peta di bawah ini.')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama Team Satria')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required(),
                                TextInput::make('no_hp')
                                    ->label('Nomor HP')
                                    ->tel()
                                    ->required(),
                                TextInput::make('alamat')
                                    ->label('Alamat')
                                    ->required(),
                                Select::make('kabupaten_id')
                                    ->label('Kabupaten/Kota')
                                    ->extraInputAttributes([
                                        'style' => 'z-index: 9999; position: relative;',
                                    ])
                                    ->options(
                                        fn() =>  collect(static::getKabupaten())->pluck('name', 'id')
                                    )
                                    ->required()->live()->searchable()->native(),
                                Select::make('kecamatan_id')
                                    ->label('Kecamatan')
                                    ->options(function (Get $get) {
                                        $kabupaten = $get('kabupaten_id');
                                        if (!$kabupaten) {
                                            return [];
                                        }
                                        return collect(static::getKecamatan($kabupaten))->pluck('name', 'id');
                                    })->required()->native()->searchable()->live(),
                            ]),
                        LocationPicker::make('location')
                            ->label('Pilih Lokasi')
                            ->helperText('Klik pada peta untuk memilih lokasi Anda.')
                            ->required()
                            ->columnSpanFull(),
                        // Other form components...
                    ])
            ]);
    }

    protected static function getKabupaten($id = '32'): array
    {
        return Cache::remember("kabupaten_all_{$id}", now()->addHours(24), function () use ($id) {
            try {
                $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regencies/' . $id . '.json');
                $response->throw();

                return $response->json() ?? [];
            } catch (\Throwable $th) {
                return [];
            }
        });
    }
    protected static function getKecamatan($id): array
    {
        return Cache::remember("kabupaten_all_{$id}", now()->addHours(24), function () use ($id) {
            try {
                $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/districts/' . $id . '.json');
                $response->throw();

                return $response->json() ?? [];
            } catch (\Throwable $th) {
                return [];
            }
        });
    }
}
