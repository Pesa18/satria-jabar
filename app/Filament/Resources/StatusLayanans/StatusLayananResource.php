<?php

namespace App\Filament\Resources\StatusLayanans;

use App\Filament\Resources\StatusLayanans\Pages\CreateStatusLayanan;
use App\Filament\Resources\StatusLayanans\Pages\EditStatusLayanan;
use App\Filament\Resources\StatusLayanans\Pages\ListStatusLayanans;
use App\Filament\Resources\StatusLayanans\Schemas\StatusLayananForm;
use App\Filament\Resources\StatusLayanans\Tables\StatusLayanansTable;
use App\Models\StatusLayanan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StatusLayananResource extends Resource
{
    protected static ?string $model = StatusLayanan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static bool $isScopedToTenant = false;

    protected static ?string $recordTitleAttribute = 'StatusLayanan';

    public static function form(Schema $schema): Schema
    {
        return StatusLayananForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatusLayanansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatusLayanans::route('/'),
            'create' => CreateStatusLayanan::route('/create'),
            'edit' => EditStatusLayanan::route('/{record}/edit'),
        ];
    }
}
