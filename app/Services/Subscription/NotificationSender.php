<?php

namespace App\Services\Subscription;

use App\Models\Eloquent\Client;
use App\Notifications\Subscription\SubscriptionCompleted as Notification;
use App\Services\NotificationTypes;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;

final class NotificationSender
{
    /**
     * @throws \Exception
     */
    public function send(NotificationTypes $senderType, int $clientId): bool
    {
        $success = true;

        $client = Client::find($clientId);

        switch ($senderType) {
            case NotificationTypes::TELEGRAM:
                try {
                    $client->notify(new Notification());
                } catch (CouldNotSendNotification $e) {
                    Log::error("idClient = {$client->id};   " . $e->__toString());
                    $success = false;
                }
                break;
            default:
                throw new \Exception("Failed to send message to client id=" . $client->id);
        }

        return $success;
    }
}
