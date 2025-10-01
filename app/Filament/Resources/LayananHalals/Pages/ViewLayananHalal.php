<?php

namespace App\Filament\Resources\LayananHalals\Pages;

use App\Filament\Resources\LayananHalals\LayananHalalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLayananHalal extends ViewRecord
{
    protected static string $resource = LayananHalalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
