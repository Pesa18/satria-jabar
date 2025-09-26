<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WhatsAppNotification extends Notification
{
    use Queueable;
    public ?array $response = null;
    /**
     * Create a new notification instance.
     */
    public function __construct(protected string $message,)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['whatsapp'];
    }

    public function toWhatsApp($notifiable)
    {

        // dd($notifiable);
        return [
            'phone' => $this->formatPhoneNumber($notifiable->no_hp), // pastikan model User ada field phone
            'message' => $this->message,
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    function formatPhoneNumber(string $number): string
    {
        $number = preg_replace('/\D/', '', $number); // hapus spasi/tanda

        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        return $number;
    }
}
