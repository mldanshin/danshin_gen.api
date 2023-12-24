<?php

namespace App\Repositories\Dates\Subscription;

use App\Exceptions\DataNotFoundException;
use App\Models\Dates\Subscription\Creator as CreatorModel;
use App\Models\Dates\Subscription\Data as DataModel;
use App\Models\Dates\Subscription\Exist as ExistModel;
use App\Models\Eloquent\PersonUser as PersonUserModel;
use App\Models\Eloquent\People as PeopleModel;
use App\Models\Eloquent\SubscriberCode as SubscriberCodeModel;
use App\Models\Eloquent\SubscriberEvent as SubscriberEventModel;
use App\Models\Eloquent\Telegram as TelegramModel;

final class Telegram implements Contract
{
    public function __construct(private Code $code)
    {
    }

    public function getData(int $personId): DataModel
    {
        return new DataModel(
            config("services.telegram-bot-api.url"),
            $this->code->create($personId)
        );
    }

    public function create(CreatorModel $creator): void
    {
        $personId = SubscriberCodeModel::where("code", "=", $creator->code)->value("user_id");
        if ($personId === null) {
            throw new DataNotFoundException("The received code = {$creator->code} does not exist in the database");
        }

        $telegramId = $this->createTelegram($creator, $personId);
        $this->createEvents($personId, $telegramId);
    }

    public function delete(int $personId): void
    {
        $user = $this->getUser($personId);

        SubscriberEventModel::where("user_id", $user->id)->delete();
        TelegramModel::where("person_id", $personId)->delete();
    }

    public function exists(int $personId): ExistModel
    {
        return new ExistModel($this->getUser($personId)->isSubscription());
    }

    private function getUser(int $personId): PersonUserModel
    {
        $person = PeopleModel::find($personId);
        if ($person === null) {
            throw new DataNotFoundException("Requested person does not exist.");
        }

        $user = PersonUserModel::where("person_id", $personId)->first();
        if ($user === null) {
            throw new DataNotFoundException("The requested person is not registered as a user.");
        }

        return $user;
    }

    private function createTelegram(CreatorModel $creator, int $personId): int
    {
        $model = TelegramModel::where("person_id", $personId)->first();
        if ($model !== null) {
            return $model->id;
        }

        $model = TelegramModel::where("telegram_id", $creator->publisherId)->first();
        if ($model !== null) {
            return $model->id;
        }

        $model = new TelegramModel();
        $model->person_id = $personId;
        $model->telegram_id = $creator->publisherId;
        $model->telegram_username = $creator->publisherName;
        $model->save();

        return $model->id;
    }

    private function createEvents(int $personId, int $telegramId): void
    {
        $model = SubscriberEventModel::where("user_id", $personId)->first();
        if ($model === null) {
            $model = new SubscriberEventModel();
            $model->user_id = $personId;
            $model->telegram_id = $telegramId;
            $model->save();
        }
    }
}
