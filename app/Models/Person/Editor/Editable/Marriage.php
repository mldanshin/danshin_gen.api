<?php

namespace App\Models\Person\Editor\Editable;

final readonly class Marriage
{
    public function __construct(
        public int $role,
        public int $soulmate,
        public int $soulmateRole,
    ) {
    }
}
