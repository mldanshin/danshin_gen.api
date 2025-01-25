<?php

namespace App\Models\Person\Editor\Created;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'personEditorCreatedMarriage',
    title: 'Брак (совместное проживание).',
    required: [
        'roleCurrent',
        'soulmate',
        'roleSoulmate',
    ]
)]
final readonly class Marriage
{
    public function __construct(
        #[OA\Property(
            description: 'Id роли текущего лица.',
        )]
        public int $role,

        #[OA\Property(
            description: 'Id второго лица.',
        )]
        public int $soulmate,

        #[OA\Property(
            description: 'Id роли второго лица.',
        )]
        public int $soulmateRole,
    ) {}
}
