<?php

namespace App\Models\Person\Reader;

use App\Models\Date;

final readonly class Photo
{
    public function __construct(
        public int $order,
        public string $fileName,
        public ?Date $date
    ) {
    }
}
