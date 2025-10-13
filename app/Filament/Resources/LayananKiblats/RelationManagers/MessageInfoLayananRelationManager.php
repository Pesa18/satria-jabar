<?php

namespace App\Filament\Resources\LayananKiblats\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\LayananKiblats\LayananKiblatResource;

class MessageInfoLayananRelationManager extends RelationManager
{
    protected static string $relationship = 'MessageInfoLayanan';

    protected static ?string $relatedResource = LayananKiblatResource::class;

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('No')->rowIndex(),
            TextColumn::make('LayananKiblat.no_hp')->label('No HP'),
            TextColumn::make('status')->badge(),
            TextColumn::make('last_message')->label("Pesan Terakhir")->wrap()->limit(10)->tooltip(fn(string $state): string => $state),
            TextColumn::make('created_at')->date('d M Y  H:i:s')->label('Waktu')
        ])
            ->headerActions([
                //
            ]);
    }
}
