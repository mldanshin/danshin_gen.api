<?php

namespace App\Models\Person\Editor\Created;

use App\Models\Date;
use Illuminate\Support\Collection;

final readonly class Person
{
    /**
     * @param Collection<int, OldSurname>|null $oldSurname
     * @param Collection<int, string>|null $activities
     * @param Collection<int, string>|null $emails
     * @param Collection<int, Internet>|null $internet
     * @param Collection<int, string>|null $phones
     * @param Collection<int, Residence>|null $residences
     * @param Collection<int, ParentModel>|null $parents
     * @param Collection<int, Marriage>|null $marriages
     */
    public function __construct(
        public bool $isUnavailable,
        public bool $isLive,
        public int $gender,
        public ?string $surname,
        public ?Collection $oldSurname,
        public ?string $name,
        public ?string $patronymic,
        public ?Date $birthDate,
        public ?string $birthPlace,
        public ?Date $deathDate,
        public ?string $burialPlace,
        public ?string $note,
        public ?Collection $activities,
        public ?Collection $emails,
        public ?Collection $internet,
        public ?Collection $phones,
        public ?Collection $residences,
        public ?Collection $parents,
        public ?Collection $marriages,
        public bool $hasPatronymic
    ) {
    }
}
