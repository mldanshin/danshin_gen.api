<?php

namespace App\Models\Dates\Subscription;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "datesSubscriptionData",
    title: "URL телеграма и код.",
    required: [
        "publisherUrl",
        "code",
    ]
)]
final readonly class Data
{
    public function __construct(
        #[OA\Property(
            description: "URL.",
        )]
        public string $publisherUrl,

        #[OA\Property(
            description: "Код.",
        )]
        public string $code
    ) {
    }
}
