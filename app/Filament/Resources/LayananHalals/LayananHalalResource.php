<?php

namespace App\Filament\Resources\LayananHalals;

use App\Filament\Resources\LayananHalals\Pages\CreateLayananHalal;
use App\Filament\Resources\LayananHalals\Pages\EditLayananHalal;
use App\Filament\Resources\LayananHalals\Pages\ListLayananHalals;
use App\Filament\Resources\LayananHalals\Pages\ViewLayananHalal;
use App\Filament\Resources\LayananHalals\RelationManagers\MessageInfoLayananRelationManager;
use App\Filament\Resources\LayananHalals\Schemas\LayananHalalForm;
use App\Filament\Resources\LayananHalals\Tables\LayananHalalsTable;
use App\Models\LayananHalal;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LayananHalalResource extends Resource
{
    protected static ?string $model = LayananHalal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Layanan SATRIA';
    protected static bool $isScopedToTenant = false;
    protected static ?string $recordTitleAttribute = 'LayananHalal';

    public static function form(Schema $schema): Schema
    {
        return LayananHalalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayananHalalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MessageInfoLayananRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLayananHalals::route('/'),
            'create' => CreateLayananHalal::route('/create'),
            'view' => ViewLayananHalal::route('/{record}'),
            'edit' => EditLayananHalal::route('/{record}/edit'),
        ];
    }
}
