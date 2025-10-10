<?php

namespace App\Filament\Resources\LayananHalals\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use message_info_layanan;

class MessageInfoLayananRelationManager extends RelationManager
{
    protected static string $relationship = 'MessageInfoLayanan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('No')->rowIndex(),
            TextColumn::make('LayananHalal.no_hp')->label('No HP'),
            TextColumn::make('status')->badge(),
            TextColumn::make('last_message')->label("Pesan Terakhir")->wrap()->limit(10)->tooltip(fn(string $state): string => $state),
            TextColumn::make('created_at')->date('d M Y  H:i:s')->label('Waktu')

        ])->collapsedGroupsByDefault();
    }
}
