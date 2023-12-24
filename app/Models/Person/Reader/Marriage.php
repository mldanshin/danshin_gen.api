<?php

namespace App\Models\Person\Reader;

final readonly class Marriage
{
    public function __construct(
        public PersonShort $soulmate,
        public int $role
    ) {
    }
}
