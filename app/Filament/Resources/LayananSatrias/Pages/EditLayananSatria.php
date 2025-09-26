<?php

namespace App\Filament\Resources\LayananSatrias\Pages;

use App\Filament\Resources\LayananSatrias\LayananSatriaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLayananSatria extends EditRecord
{
    protected static string $resource = LayananSatriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
