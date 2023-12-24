<?php

namespace App\Models\Dates;

use Illuminate\Support\Collection;

final readonly class Events
{
    public bool $isEmpty;
    
    /**
     * @param Collection<int, Birth> $pastBirth
     * @param Collection<int, BirthWould> $pastBirthWould
     * @param Collection<int, Death> $pastDeath
     * @param Collection<int, Birth> $todayBirth
     * @param Collection<int, BirthWould> $todayBirthWould
     * @param Collection<int, Death> $todayDeath
     * @param Collection<int, Birth> $nearestBirth
     * @param Collection<int, BirthWould> $nearestBirthWould
     * @param Collection<int, Death> $nearestDeath
     */
    public function __construct(
        public Collection $pastBirth,
        public Collection $pastBirthWould,
        public Collection $pastDeath,
        public Collection $todayBirth,
        public Collection $todayBirthWould,
        public Collection $todayDeath,
        public Collection $nearestBirth,
        public Collection $nearestBirthWould,
        public Collection $nearestDeath
    ) {
        $this->initializeIsEmpty();
    }

    private function initializeIsEmpty(): void
    {
        if ($this->pastBirth->count() === 0
            && $this->pastBirthWould->count() === 0
            && $this->pastDeath->count() === 0
            && $this->todayBirth->count() === 0
            && $this->todayBirthWould->count() === 0
            && $this->todayDeath->count() === 0
            && $this->nearestBirth->count() === 0
            && $this->nearestBirthWould->count() === 0
            && $this->nearestDeath->count() === 0
        ) {
            $this->isEmpty = true;
        } else {
            $this->isEmpty = false;
        }
    }
}
