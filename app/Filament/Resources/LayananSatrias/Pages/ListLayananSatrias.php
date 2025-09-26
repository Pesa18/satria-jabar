<?php

namespace App\Filament\Resources\LayananSatrias\Pages;

use App\Filament\Resources\LayananSatrias\LayananSatriaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLayananSatrias extends ListRecords
{
    protected static string $resource = LayananSatriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
