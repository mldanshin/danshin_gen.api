<?php

namespace App\Models\Dates;

use App\Models\Date;

final readonly class BirthWould extends Event
{
    public function __construct(
        Date $date,
        Person $person,
        public \DateInterval $age
    ) {
        parent::__construct($date, $person);
    }
}
