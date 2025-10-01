<?php

namespace App\Filament\Resources\StatusLayanans\Pages;

use App\Filament\Resources\StatusLayanans\StatusLayananResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatusLayanans extends ListRecords
{
    protected static string $resource = StatusLayananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
