<?php

namespace App\Filament\Resources\LayananMasjids\Pages;

use App\Filament\Resources\LayananMasjids\LayananMasjidResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLayananMasjids extends ListRecords
{
    protected static string $resource = LayananMasjidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
