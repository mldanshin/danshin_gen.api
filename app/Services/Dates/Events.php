<?php

namespace App\Services\Dates;

use App\Models\Eloquent\PersonUser;
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

        $users = PersonUser::has("subscriptionEvent")->has("telegram")->get();
        if (empty($users) || $users->isEmpty()) {
            Log::info(self::class . "; User not has subscription event");
            return true;
        }

        $sender = new NotificationSender(
            NotificationTypes::TELEGRAM,
            $model,
            $users,
            $pathPerson
        );

        return $sender->send();
    }
}
