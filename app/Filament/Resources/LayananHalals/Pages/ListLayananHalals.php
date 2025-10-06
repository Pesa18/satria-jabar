<?php

namespace App\Filament\Resources\LayananHalals\Pages;

use App\Filament\Resources\LayananHalals\LayananHalalResource;
use App\Notifications\Channels\WhatsAppChannel;
use App\Notifications\WhatsAppNotification;
use App\View\Components\SelectMessageTemplate;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Group;

class ListLayananHalals extends ListRecords
{
    protected static string $resource = LayananHalalResource::class;
    public function testAction(): Action
    {
        return Action::make('test')
            ->requiresConfirmation()
            ->form([
                Group::make()->schema([
                    Textarea::make('isi_pesan')->rows(12),
                ])

            ])
            ->mountUsing(function (array $arguments, $form) {
                $record = $arguments['record'];
                $pesanTemplate = $arguments['pesan'] ?? '';

                // 🔧 Ganti semua {{key}} dengan nilai dari record
                $pesan = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($record) {
                    $key = trim($matches[1]);
                    return data_get($record, $key, ''); // pakai data_get agar bisa ambil relasi juga
                }, $pesanTemplate);
                $form->fill([
                    'isi_pesan' => $pesan
                ]);
            })
            ->action(function (array $arguments, $form) {
                $record = $arguments['record']; // record LayananHalal yang bersangkutan
                $pesan = $form->getState('isi_pesan'); // pastikan ambil dengan key
                $pesan = is_array($pesan) ? $pesan['isi_pesan'] ?? '' : $pesan;
                $whatsappNotif = new WhatsAppNotification($pesan);
                $record->notify($whatsappNotif);
            })
            ->modalWidth('2xl')
        ;
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
