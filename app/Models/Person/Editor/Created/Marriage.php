<?php

namespace App\Models\Person\Editor\Created;

final readonly class Marriage
{
    public function __construct(
        private int $roleCurrent,
        private int $soulmate,
        private int $roleSoulmate,
    ) {
    }
}
