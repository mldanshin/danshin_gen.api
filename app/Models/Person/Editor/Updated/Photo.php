<?php

namespace App\Models\Person\Editor\Updated;

use App\Models\Date;

final readonly class Photo
{
    public function __construct(
        public int $order,
        public ?Date $date,
        public string $fileName
    ) {
    }
}