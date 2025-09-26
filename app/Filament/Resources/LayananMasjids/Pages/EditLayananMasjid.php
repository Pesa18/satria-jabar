<?php

namespace App\Filament\Resources\LayananMasjids\Pages;

use App\Filament\Resources\LayananMasjids\LayananMasjidResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLayananMasjid extends EditRecord
{
    protected static string $resource = LayananMasjidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
