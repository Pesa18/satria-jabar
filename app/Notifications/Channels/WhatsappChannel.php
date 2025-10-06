<?php

namespace App\Notifications\Channels;

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
            Http::withHeaders([
                'X-Api-Key' => env("API_KEY_WAHA"),
            ])->post('https://waha.satriapp.my.id/api/sendText', [
                "chatId" => $data['phone'],
                "reply_to" => null,
                "text" => $data['message'],
                "linkPreview" => true,
                "linkPreviewHighQuality" => false,
                "session" => "default"
            ]);
        } catch (\Throwable $th) {

            return  false;
        }
    }
}
