<?php

namespace App\Filament\Resources\LayananKiblats\Pages;

use App\Filament\Resources\LayananKiblats\LayananKiblatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLayananKiblat extends ViewRecord
{
    protected static string $resource = LayananKiblatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
