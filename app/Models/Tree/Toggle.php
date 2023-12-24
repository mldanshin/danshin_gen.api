<?php

namespace App\Models\Tree;

use Illuminate\Support\Collection;

final readonly class Toggle
{
    /**
     * @param Collection<int, PersonShort> $parentList
     */
    public function __construct(
        public PersonShort $personTarget,
        public Collection $parentList,
        public int $parentTarget
    ) {
    }
}
