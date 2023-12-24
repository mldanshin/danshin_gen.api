<?php

namespace App\Models\Person\Editor\Editable;

use App\Models\Date;

final readonly class Residence
{
    public function __construct(
        public string $name,
        public ?Date $date
    ) {
    }
}
