<?php

namespace App\Models\Person\Editor\Editable;

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
