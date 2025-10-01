<?php

namespace App\Filament\Resources\LayananSatrias\Tables;

use App\Services\WilayahServices;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

class LayananSatriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama Tim Satria')->searchable()->sortable(),
                TextColumn::make('alamat')->label('Alamat')->searchable()->sortable(),
                TextColumn::make('no_hp')->label('No. HP')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable(),
                TextColumn::make('kabupaten_id')->label('Kabupaten/Kota')->searchable()->sortable()->formatStateUsing(fn($state, WilayahServices $wilayah) => $state ? $wilayah->getKabupatenName($state) : '-'),
                TextColumn::make('kecamatan_id')->label('Kecamatan')->searchable()->sortable()->formatStateUsing(fn($state, WilayahServices $wilayah) => $state ? $wilayah->getKecamatanName($state) : '-'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
