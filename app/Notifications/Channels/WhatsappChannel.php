<?php

namespace App\Notifications\Channels;

use App\Models\MessageInfoLayanan;
use App\Notifications\WhatsAppNotification;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;


class WhatsAppChannel
{
    public function send($notifiable, WhatsAppNotification $notification)
    {


        if (! method_exists($notification, 'toWhatsApp')) {
            return;
        }

        try {
            $data = $notification->toWhatsApp($notifiable);
            $response = Http::withHeaders([
                'X-Api-Key' => env("API_KEY_WAHA"),
            ])->post('https://waha.satriapp.my.id/api/sendText', [
                "chatId" => $data['phone'],
                "reply_to" => null,
                "text" => $data['message'],
                "linkPreview" => true,
                "linkPreviewHighQuality" => false,
                "session" => "default"
            ]);
            if (!$response->successful()) {
                return   MessageInfoLayanan::create([
                    $notifiable->layanan => $notifiable->id,
                    'status' => 'gagal',
                    'last_message' => $data['message']

                ]);
            }
            MessageInfoLayanan::create([
                $notifiable->layanan => $notifiable->id,
                'status' => 'succes',
                'last_message' => $data['message']

            ]);
        } catch (\Throwable $th) {
            dd($th);
            return  Notification::make()
                ->title('Gagal Mengirim Notifikasi WhatsApp')
                ->danger()
                ->send();
        }
    }
}
