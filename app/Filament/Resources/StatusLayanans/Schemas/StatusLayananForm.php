<?php

namespace App\Filament\Resources\StatusLayanans\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StatusLayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_status'),
                Textarea::make('deskripsi'),
                RichEditor::make('pesan')->json()

            ]);
    }
}
