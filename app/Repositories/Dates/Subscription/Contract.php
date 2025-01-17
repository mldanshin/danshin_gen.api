<?php

namespace App\Repositories\Dates\Subscription;

use App\Models\Dates\Subscription\Creator as CreatorModel;
use App\Models\Dates\Subscription\Data as DataModel;
use App\Models\Dates\Subscription\Exist as ExistModel;

interface Contract
{
    function getData(int $clientId): DataModel;
    function create(CreatorModel $creator): int;
    function delete(int $clientId): void;
    function exists(int $clientId): ExistModel;
}
