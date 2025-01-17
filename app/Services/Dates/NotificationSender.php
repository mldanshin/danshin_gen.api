<?php

namespace App\Services\Dates;

use App\Models\Eloquent\Client;
use App\Models\Dates\Events;
use App\Notifications\Dates\Dates as Notification;
use App\Services\NotificationTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

final class NotificationSender
{
    /**
     * @param Collection|Client[] $clients
     */
    public function __construct(
        private NotificationTypes $senderType,
        private Events $events,
        private Collection $clients,
        private string $pathPerson
    ) {
    }

    /**
     * @throws \Exception
     */
    public function send(): bool
    {
        $success = true;

        switch ($this->senderType) {
            case NotificationTypes::TELEGRAM:
                foreach ($this->clients as $client) {
                    try {
                        $client->notify(new Notification($this->events, $this->pathPerson));
                    } catch (CouldNotSendNotification $e) {
                        Log::error("idClient = {$client->id};   " . $e->__toString());
                        $success = false;
                    }
                }
                break;
            default:
                throw new \Exception("The sender is missing");
        }

        return $success;
    }
}
