<?php

namespace App\Models\Person\Editor\Editable;

final readonly class ParentModel
{
    public function __construct(
        public int $person,
        public int $role
    ) {
    }
}
