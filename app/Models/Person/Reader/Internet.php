<?php

namespace App\Models\Person\Reader;

final readonly class Internet
{
    public function __construct(
        public string $url,
        public string $name
    ) {
    }
}
