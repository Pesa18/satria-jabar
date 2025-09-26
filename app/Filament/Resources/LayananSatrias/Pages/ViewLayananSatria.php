<?php

namespace App\Filament\Resources\LayananSatrias\Pages;

use App\Filament\Resources\LayananSatrias\LayananSatriaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLayananSatria extends ViewRecord
{
    protected static string $resource = LayananSatriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
