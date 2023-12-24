<?php

namespace App\Models\Dates;

use App\Models\Date as ModelsDate;

final readonly class Date extends Event
{
    public function __construct(
        ModelsDate $date,
        public DateType $type,
        Person $person
    ) {
        parent::__construct($date, $person);
    }
}
