<?php

namespace App\Filament\Resources\LayananHalals\Pages;

use App\Filament\Resources\LayananHalals\LayananHalalResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLayananHalal extends EditRecord
{
    protected static string $resource = LayananHalalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
