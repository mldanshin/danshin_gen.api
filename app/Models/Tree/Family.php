<?php

namespace App\Models\Tree;

use Illuminate\Support\Collection;

final readonly class Family
{
    /**
     * @param Collection<int, Person> $marriage
     * @param Collection<int, Family> $children
     */
    public function __construct(
        public Person $person,
        public Collection $marriage,
        public Collection $children
    ) {
    }
}
