<?php

namespace App\Models\Person\Editor\Stored;

use App\Models\Date;

final readonly class Residence
{
    public function __construct(
        public string $name,
        public ?Date $date
    ) {}
}
