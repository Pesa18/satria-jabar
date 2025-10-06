<?php

namespace App\Filament\Resources\StatusLayanans\Tables;

use App\Models\StatusLayanan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StatusLayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')->rowIndex(),
                TextColumn::make('nama_status')->description(fn(StatusLayanan $record): string => $record->deskripsi),
                TextColumn::make('pesan')->limit(20, end: ' (lihat)')->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();

                    if (strlen($state) <= $column->getCharacterLimit()) {
                        return null;
                    }

                    // Only render the tooltip if the column contents exceeds the length limit.
                    return $state;
                })->wrap()

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
