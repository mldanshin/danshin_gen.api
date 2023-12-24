<?php

namespace App\Services\Dates;

final readonly class TelegramUser
{
    public function __construct(
        public string $id,
        public ?string $username
    ) {
    }
}
