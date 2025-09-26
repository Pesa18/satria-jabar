<?php

namespace App\Filament\Resources\LayananMasjids;

use App\Filament\Resources\LayananMasjids\Pages\CreateLayananMasjid;
use App\Filament\Resources\LayananMasjids\Pages\EditLayananMasjid;
use App\Filament\Resources\LayananMasjids\Pages\ListLayananMasjids;
use App\Filament\Resources\LayananMasjids\Schemas\LayananMasjidForm;
use App\Filament\Resources\LayananMasjids\Tables\LayananMasjidsTable;
use App\Models\LayananMasjid;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LayananMasjidResource extends Resource
{
    protected static ?string $model = LayananMasjid::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Layanan SATRIA';
    protected static bool $isScopedToTenant = false;
    protected static ?string $recordTitleAttribute = 'LayananMasjid';

    public static function form(Schema $schema): Schema
    {
        return LayananMasjidForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayananMasjidsTable::configure($table);
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
            'index' => ListLayananMasjids::route('/'),
            'create' => CreateLayananMasjid::route('/create'),
            'edit' => EditLayananMasjid::route('/{record}/edit'),
        ];
    }
}
