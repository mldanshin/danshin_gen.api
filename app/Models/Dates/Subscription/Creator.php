<?php

namespace App\Models\Dates\Subscription;

final readonly class Creator
{
    public function __construct(
        public string $code,
        public string $publisherId,
        public ?string $publisherName
    ) {
    }
}
