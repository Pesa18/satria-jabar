<?php

namespace App\Filament\Resources\LayananSatrias;

use App\Filament\Resources\LayananSatrias\Pages\CreateLayananSatria;
use App\Filament\Resources\LayananSatrias\Pages\EditLayananSatria;
use App\Filament\Resources\LayananSatrias\Pages\ListLayananSatrias;
use App\Filament\Resources\LayananSatrias\Pages\ViewLayananSatria;
use App\Filament\Resources\LayananSatrias\Schemas\LayananSatriaForm;
use App\Filament\Resources\LayananSatrias\Schemas\LayananSatriaInfolist;
use App\Filament\Resources\LayananSatrias\Tables\LayananSatriasTable;
use App\Models\LayananSatria;
use App\Models\TeamSatria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LayananSatriaResource extends Resource
{
    protected static ?string $model = TeamSatria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static bool $isScopedToTenant = false;

    protected static ?string $recordTitleAttribute = 'team_satria';

    public static function form(Schema $schema): Schema
    {
        return LayananSatriaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LayananSatriaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LayananSatriasTable::configure($table);
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
            'index' => ListLayananSatrias::route('/'),
            'create' => CreateLayananSatria::route('/create'),
            'view' => ViewLayananSatria::route('/{record}'),
            'edit' => EditLayananSatria::route('/{record}/edit'),
        ];
    }
}
