<?php

namespace App\Notifications\Subscription;

use App\Models\Eloquent\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class SubscriptionCompleted extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return string[]
     */
    public function via(mixed $notifiable): array
    {
        return ["telegram"];
    }

    public function toTelegram(Client $notifiable): TelegramMessage
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram()->first()->telegram_id)
            ->view("subscription.notifications.subscription-completed");
    }
}
