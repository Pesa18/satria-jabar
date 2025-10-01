<?php

namespace App\Filament\Resources\LayananSatrias\Schemas;

use App\Filament\Forms\Components\LocationPicker;
use App\Services\WilayahServices;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;


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
                                        fn(WilayahServices $wilayah) =>  collect($wilayah->getKabupaten())->pluck('name', 'id')
                                    )
                                    ->required()->live()->searchable()->native(),
                                Select::make('kecamatan_id')
                                    ->label('Kecamatan')
                                    ->options(function (Get $get, WilayahServices $wilayah) {
                                        $kabupaten = $get('kabupaten_id');
                                        if (!$kabupaten) {
                                            return [];
                                        }
                                        return collect($wilayah->getKecamatan($kabupaten))->pluck('name', 'id');
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
}
