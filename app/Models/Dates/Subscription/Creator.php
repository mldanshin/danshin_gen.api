<?php

namespace App\Models\Dates\Subscription;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "datesSubscriptionCreator",
    title: "Входящий запрос телеграм.",
    required: [
        "code",
        "publisherId",
        "publisherName"
    ]
)]
final readonly class Creator
{
    public function __construct(
        #[OA\Property(
            description: "Код.",
        )]
        public string $code,

        #[OA\Property(
            description: "Публичный ID.",
        )]
        public string $publisherId,

        #[OA\Property(
            description: "Публичное имя.",
        )]
        public ?string $publisherName
    ) {
    }
}
