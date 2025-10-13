<?php

namespace App\Filament\Resources\LayananKiblats\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ListRecords;
use App\Notifications\WhatsAppNotification;
use App\Filament\Resources\LayananKiblats\LayananKiblatResource;

class ListLayananKiblats extends ListRecords
{
    protected static string $resource = LayananKiblatResource::class;
    public function MessageAction(): Action
    {
        return Action::make('message')
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
                $record['layanan'] = 'layanan_kiblat_id';
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
