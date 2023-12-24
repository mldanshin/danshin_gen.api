<?php

namespace App\Services\Dates;

use App\Models\Eloquent\PersonUser;
use App\Models\Dates\Events;
use App\Notifications\Dates\Dates as Notification;
use App\Services\NotificationTypes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

final class NotificationSender
{
    /**
     * @param Collection|PersonUser[] $users
     */
    public function __construct(
        private NotificationTypes $senderType,
        private Events $events,
        private Collection $users,
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
                foreach ($this->users as $user) {
                    try {
                        $user->notify(new Notification($this->events, $this->pathPerson));
                    } catch (CouldNotSendNotification $e) {
                        Log::error("idUser = {$user->id};   " . $e->__toString());
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
