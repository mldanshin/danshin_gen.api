<?php

namespace App\Services\Dates;

use App\Models\Eloquent\Client;
use App\Repositories\Dates\DatesUpcoming as Repository;
use App\Services\NotificationTypes;
use Illuminate\Support\Facades\Log;

final class Events
{
    public function __construct(private Repository $repository)
    {
    }

    public function send(\DateTime $date, int $pastDay, int $nearestDay, string $pathPerson): bool
    {
        $model = $this->repository->get($date, $pastDay, $nearestDay);
        if ($model->isEmpty) {
            Log::info(self::class . "Events is missing");
            return true;
        }

        $clients = Client::has("subscriptionEvent")->has("telegram")->get();
        if (empty($clients) || $clients->isEmpty()) {
            Log::info(self::class . "; Clients not has subscription event");
            return true;
        }

        $sender = new NotificationSender(
            NotificationTypes::TELEGRAM,
            $model,
            $clients,
            $pathPerson
        );

        return $sender->send();
    }
}
