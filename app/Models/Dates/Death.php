<?php

namespace App\Models\Dates;

use App\Models\Date;

final readonly class Death extends Event
{
    public function __construct(
        Date $date,
        Person $person,
        public ?\DateInterval $age,
        public \DateInterval $interval
    ) {
        parent::__construct($date, $person);
    }
}
