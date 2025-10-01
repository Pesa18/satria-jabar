<?php

namespace App\Filament\Resources\StatusLayanans\Pages;

use App\Filament\Resources\StatusLayanans\StatusLayananResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStatusLayanan extends EditRecord
{
    protected static string $resource = StatusLayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
