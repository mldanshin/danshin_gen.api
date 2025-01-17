<?php

namespace App\Repositories\Dates\Subscription;

use App\Exceptions\DataNotFoundException;
use App\Models\Dates\Subscription\Creator as CreatorModel;
use App\Models\Dates\Subscription\Data as DataModel;
use App\Models\Dates\Subscription\Exist as ExistModel;
use App\Models\Eloquent\Client as ClientModel;
use App\Models\Eloquent\SubscriberCode as SubscriberCodeModel;
use App\Models\Eloquent\SubscriberEvent as SubscriberEventModel;
use App\Models\Eloquent\Telegram as TelegramModel;
use Illuminate\Support\Facades\Log;

final class Telegram implements Contract
{
    public function __construct(private Code $code)
    {
    }

    public function getData(int $clientId): DataModel
    {
        return new DataModel(
            config("services.telegram-bot-api.url"),
            $this->code->create($clientId)
        );
    }

    public function create(CreatorModel $creator): int
    {
        Log::info("Telegram code {$creator->code} publisherId={$creator->publisherId}");

        $subscriberCode = SubscriberCodeModel::where("code", $creator->code)->first();
        if ($subscriberCode === null) {
            throw new DataNotFoundException("The received code = {$creator->code} does not exist in the database");
        }

        $telegramId = $this->createTelegram($creator, $subscriberCode->client_id);
        $this->createEvents($subscriberCode->client_id, $telegramId);

        return $subscriberCode->client_id;
    }

    public function delete(int $clientId): void
    {
        $client = $this->getClient($clientId);

        SubscriberEventModel::where("client_id", $client->id)->delete();
        TelegramModel::where("client_id", $clientId)->delete();
    }

    public function exists(int $clientId): ExistModel
    {
        return new ExistModel($this->getClient($clientId)->isSubscription());
    }

    private function getClient(int $clientId): ClientModel
    {
        $client = ClientModel::where("id", $clientId)->first();
        if ($client === null) {
            throw new DataNotFoundException("Client with id=$clientId number not found.");
        }

        return $client;
    }

    private function createTelegram(CreatorModel $creator, int $clientId): int
    {
        $model = TelegramModel::where("client_id", $clientId)->first();
        if ($model !== null) {
            return $model->id;
        }

        $model = TelegramModel::where("telegram_id", $creator->publisherId)->first();
        if ($model !== null) {
            return $model->id;
        }

        $model = new TelegramModel();
        $model->client_id = $clientId;
        $model->telegram_id = $creator->publisherId;
        $model->telegram_username = $creator->publisherName;
        $model->save();

        return $model->id;
    }

    private function createEvents(int $clientId, int $telegramId): void
    {
        $model = SubscriberEventModel::where("client_id", $clientId)->first();
        if ($model === null) {
            $model = new SubscriberEventModel();
            $model->client_id = $clientId;
            $model->telegram_id = $telegramId;
            $model->save();
        }
    }
}
