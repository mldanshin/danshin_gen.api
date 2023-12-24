<?php

namespace App\Models\Tree;

final readonly class Tree
{
    public function __construct(
        public PersonShort $personTarget,
        public Family $family
    ) {
    }
}
