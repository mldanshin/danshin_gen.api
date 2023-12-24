<?php

namespace App\Models\Dates\Subscription;

final readonly class Data
{
    public function __construct(
        public string $publisherUrl,
        public string $code
    ) {
    }
}
