<?php

namespace App\Filament\Resources\LayananSatrias\Pages;

use App\Filament\Resources\LayananSatrias\LayananSatriaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLayananSatria extends CreateRecord
{
    protected static string $resource = LayananSatriaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
