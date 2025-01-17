<?php

namespace App\Models\Client;

use Illuminate\Support\Collection;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "clientClientReader",
    title: "Описание пользователя.",
    required: [
        "id",
        "uid"
    ]
)]
final readonly class ClientReader
{
    /**
     * @param Collection<int, string>|null $oldSurname
     */
    public function __construct(
        #[OA\Property(
            description: "ID.",
        )]
        public int $id,

        #[OA\Property(
            description: "Глобальный уникальный Uid.",
        )]
        public string $uid
    ) {
    }
}
