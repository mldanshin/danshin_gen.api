<?php

namespace App\Models\Tree;

final readonly class PersonShort
{
    public function __construct(
        public int $id,
        public ?string $surname,
        public ?string $name,
        public ?string $patronymic,
    ) {
    }
}
