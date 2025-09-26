<?php

namespace App\Filament\Resources\LayananKiblats\Pages;

use App\Filament\Resources\LayananKiblats\LayananKiblatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLayananKiblat extends EditRecord
{
    protected static string $resource = LayananKiblatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
