<?php

namespace App\Filament\Resources\LayananKiblats\Pages;

use App\Filament\Resources\LayananKiblats\LayananKiblatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLayananKiblats extends ListRecords
{
    protected static string $resource = LayananKiblatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
