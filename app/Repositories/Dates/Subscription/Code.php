<?php

namespace App\Repositories\Dates\Subscription;

use App\Exceptions\DataNotFoundException;
use App\Models\Eloquent\Client as ClientModel;
use App\Models\Eloquent\SubscriberCode as SubscriberCodeModel;

final class Code
{
    public function create(int $clientId): string
    {
        $client = $this->validateClient($clientId);
        
        $code = SubscriberCodeModel::where("client_id", "=", $client->id)->value("code");
        if ($code !== null) {
            return $code;
        }

        $code = uniqid();

        $obj = new SubscriberCodeModel();
        $obj->client_id = $client->id;
        $obj->code = $code;
        $obj->time = (new \DateTimeImmutable())->getTimestamp();
        $obj->save();

        return $code;
    }

    public function clear(): void
    {
        $timeTarget = time() - config("app.subscription_code_time_clear");
        SubscriberCodeModel::where("time", "<", $timeTarget)->delete();
    }

    private function validateClient(int $clientId): ClientModel
    {
        $client = ClientModel::where("id", $clientId)->first();
        if ($client === null) {
            throw new DataNotFoundException("Client with id=$clientId number not found.");
        }

        return $client;
    }
}
