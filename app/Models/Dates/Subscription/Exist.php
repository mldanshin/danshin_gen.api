<?php

namespace App\Models\Dates\Subscription;

final readonly class Exist
{
    public function __construct(
        public bool $exist
    ) {
    }
}
