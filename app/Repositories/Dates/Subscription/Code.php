<?php

namespace App\Repositories\Dates\Subscription;

use App\Exceptions\DataNotFoundException;
use App\Models\Eloquent\PersonUser as PersonUserModel;
use App\Models\Eloquent\People as PeopleModel;
use App\Models\Eloquent\SubscriberCode as SubscriberCodeModel;

final class Code
{
    public function create(int $personId): string
    {
        $person = $this->validatePerson($personId);
        
        $code = SubscriberCodeModel::where("user_id", "=", $person->id)->value("code");
        if ($code !== null) {
            return $code;
        }

        $code = uniqid();

        $obj = new SubscriberCodeModel();
        $obj->user_id = $person->id;
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

    private function validatePerson(int $personId): PersonUserModel
    {
        $person = PeopleModel::find($personId);
        if ($person === null) {
            throw new DataNotFoundException("Requested person does not exist.");
        }

        $person = PersonUserModel::where("person_id", $personId)->first();
        if ($person === null) {
            throw new DataNotFoundException("The requested person is not registered as a user.");
        }

        return $person;
    }
}
