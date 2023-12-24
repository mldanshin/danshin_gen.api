<?php

namespace App\Models\Tree;

use App\Models\Date;
use Illuminate\Support\Collection;

final readonly class Person
{
    /**
     * @param Collection<int, string>|null $oldSurname
     */
    public function __construct(
        public int $id,
        public ?string $surname,
        public ?Collection $oldSurname,
        public ?string $name,
        public ?string $patronymic,
        public ?Date $birthDate,
        public ?Date $deathDate,
        public bool $isPersonTarget
    ) {
    }
}
