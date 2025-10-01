<?php

namespace App\Filament\Resources\LayananHalals\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class LayananHalalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pemohon')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('nama_pemohon')->required(),
                                TextInput::make('NIK'),
                                TextInput::make('no_hp'),
                                TextInput::make('email'),
                                DatePicker::make('tanggal_lahir')
                                    ->afterStateHydrated(
                                        function (Set $set, ?string $state,) {
                                            if ($state) {
                                                $set('umur', (int) Carbon::parse($state)->diffInYears(Carbon::now()) . ' Tahun');
                                            } else {
                                                $set('umur', null);
                                            }
                                        }
                                    )
                                    ->afterStateUpdated(
                                        function (Set $set, ?string $state,) {
                                            if ($state) {
                                                $set('umur', (int) Carbon::parse($state)->diffInYears(Carbon::now()) . ' Tahun');
                                            } else {
                                                $set('umur', null);
                                            }
                                        }
                                    )->live()->native(false),
                                TextInput::make('umur')->live()->disabled(),
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
                                Textarea::make('alamat_lengkap')
                            ])->columns(2)
                    ])->columnSpanFull()->collapsible(),

                Section::make('Data Layanan')->schema([
                    Group::make()->schema([
                        TextInput::make('no_layanan')->readOnly()->copyable(),
                        TextInput::make('nama_usaha'),
                        TextInput::make('NIB'),
                        Select::make('klasifikasi_usaha')->options(
                            [
                                'mikro' => 'mikro',
                                'kecil' => 'kecil',
                                'menengah' => 'menengah',
                                'besar' => 'besar'
                            ]
                        ),
                        Select::make('layanan_halal')->options([
                            'selfdeclare' => 'selfdeclare',
                            'reguler' => 'reguler'
                        ]),
                        Select::make('jenis_usaha')->options([
                            'makanan' => 'makanan',
                            'minuman' => 'minuman',
                            'kosmetik' => 'kosmetik',
                            'farmasi' => 'farmasi',
                            'jasa' => 'jasa',
                            'barang gunaan' => 'barang gunaan',
                            'produk kimiawi' => 'produk kimiawi',
                            'produk biologi' => 'produk biologi',
                            'lainnya' => 'lainnya'
                        ]),
                        FileUpload::make('foto_pelayanan')
                            ->directory('foto_layanan')
                            ->image()
                            ->minSize(512)
                            ->maxSize(1024),
                        Textarea::make('catatan'),
                    ])->columns(2),

                ])->columnSpanFull()->collapsible(),
                Section::make('Dokumen Pengajuan')->schema([
                    FileUpload::make('dokumen_pengajuan')
                        ->directory('dokumen_pengajuan')
                        ->acceptedFileTypes(['application/pdf'])
                        ->minSize(512)
                        ->maxSize(1024)
                ])->columnSpanFull()->collapsible()->collapsed(),

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
