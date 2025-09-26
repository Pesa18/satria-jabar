<?php

namespace App\Filament\Resources\LayananSatrias\Tables;

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
                TextColumn::make('kabupaten_id')->label('Kabupaten/Kota')->searchable()->sortable()->formatStateUsing(fn($state) => $state ? static::getKabupatenName($state) : '-'),
                TextColumn::make('kecamatan_id')->label('Kecamatan')->searchable()->sortable()->formatStateUsing(fn($state) => $state ? static::getKecamatan($state) : '-'),

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

    protected static function getKabupatenName($id)
    {
        try {
            $kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regency/" . $id . ".json")->json();
            return $kabupaten['name'] ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }
    protected static function getKecamatan($id)
    {
        try {
            $kabupaten = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/district/" . $id . ".json")->json();
            return $kabupaten['name'] ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }
}
