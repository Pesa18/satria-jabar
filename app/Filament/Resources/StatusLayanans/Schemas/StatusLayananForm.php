<?php

namespace App\Filament\Resources\StatusLayanans\Schemas;

use App\Models\LayananHalal;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Schema as FacadesSchema;

class StatusLayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Status Layanan')->schema([
                    TextInput::make('nama_status')->required(),
                    Textarea::make('deskripsi')->required(),
                    Grid::make(1)->schema([
                        Textarea::make('pesan')->required()->rows(10),
                        ViewField::make('input_pesan')->view('components.select-message-template')->viewData([
                            'fields' => collect(FacadesSchema::getColumnListing('layanan_halals'))
                                ->map(fn($column) => [
                                    'key' => $column,
                                    'label' => '{{' . $column . '}}'
                                ])
                                ->toArray(),

                        ])->disabled(),
                    ])->columns(2)

                ])->columnSpanFull()
            ]);
    }
}
