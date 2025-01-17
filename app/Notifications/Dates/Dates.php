<?php

namespace App\Notifications\Dates;

use App\Models\Eloquent\Client;
use App\Models\Dates\Events as EventsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class Dates extends Notification
{
    use Queueable;

    public function __construct(
        private EventsModel $eventsModel,
        private string $pathPerson
    ) {
    }

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
            ->view("dates.subscription.notification.events", [
                "events" => $this->eventsModel,
                "pathPerson" => $this->pathPerson
            ]);
    }
}
