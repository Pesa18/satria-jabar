<?php

namespace App\Filament\Resources\LayananKiblats;

use App\Filament\Resources\LayananKiblats\Pages\CreateLayananKiblat;
use App\Filament\Resources\LayananKiblats\Pages\EditLayananKiblat;
use App\Filament\Resources\LayananKiblats\Pages\ListLayananKiblats;
use App\Filament\Resources\LayananKiblats\Schemas\LayananKiblatForm;
use App\Filament\Resources\LayananKiblats\Tables\LayananKiblatsTable;
use App\Models\LayananKiblat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LayananKiblatResource extends Resource
{
    protected static ?string $model = LayananKiblat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string | UnitEnum | null $navigationGroup = 'Layanan SATRIA';
    protected static bool $isScopedToTenant = false;
    public static function form(Schema $schema): Schema
    {
        return LayananKiblatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayananKiblatsTable::configure($table);
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
            'index' => ListLayananKiblats::route('/'),
            'create' => CreateLayananKiblat::route('/create'),
            'edit' => EditLayananKiblat::route('/{record}/edit'),
        ];
    }
}
