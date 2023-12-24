<?php

namespace App\Models\Dates\Subscription;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "datesSubscriptionExist",
    title: "Сведения о существовании подписки.",
    required: [
        "exist",
    ]
)]
final readonly class Exist
{
    public function __construct(
        #[OA\Property(
            description: "Существует ли подписка.",
        )]
        public bool $exist
    ) {
    }
}
