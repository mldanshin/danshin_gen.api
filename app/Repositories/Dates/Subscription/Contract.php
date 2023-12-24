<?php

namespace App\Repositories\Dates\Subscription;

use App\Models\Dates\Subscription\Creator as CreatorModel;
use App\Models\Dates\Subscription\Data as DataModel;
use App\Models\Dates\Subscription\Exist as ExistModel;

interface Contract
{
    function getData(int $personId): DataModel;
    function create(CreatorModel $creator): void;
    function delete(int $personId): void;
    function exists(int $personId): ExistModel;
}
