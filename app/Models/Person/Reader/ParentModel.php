<?php

namespace App\Models\Person\Reader;

final readonly class ParentModel
{
    public function __construct(
        public PersonShort $person,
        public int $role,
    ) {
    }
}
