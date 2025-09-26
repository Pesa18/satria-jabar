<?php

namespace App\Filament\Resources\LayananHalals\Pages;

use App\Filament\Resources\LayananHalals\LayananHalalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLayananHalals extends ListRecords
{
    protected static string $resource = LayananHalalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
