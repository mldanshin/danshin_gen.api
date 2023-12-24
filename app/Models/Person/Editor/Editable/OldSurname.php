<?php

namespace App\Models\Person\Editor\Editable;

final readonly class OldSurname
{
    public function __construct(
        public string $surname,
        public int $order
    ) {
    }
}
