<?php

namespace App\Filament\Resources\LayananHalals\Tables;

use App\Models\StatusLayanan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LayananHalalsTable
{


    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')->rowIndex(),
                TextColumn::make('nama_pemohon'),
                TextColumn::make('no_layanan')->copyable(),
                TextColumn::make('teamSatria.nama'),
                TextColumn::make('status_layanan_id'),
                SelectColumn::make('status_layanan_id')->label('status')->optionsRelationship(name: 'statusLayanan', titleAttribute: 'nama_status')->beforeStateUpdated(
                    function ($record, $state, $set, $livewire) {
                        if (empty($state)) {
                            return false;
                        }
                        $pesan = StatusLayanan::find($state)?->pesan;
                        $livewire->mountAction('test', [
                            'id' => $record->id,
                            'status' => $state,
                            'pesan' => $pesan,
                            'record' => $record
                        ]);
                    }

                ),
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
