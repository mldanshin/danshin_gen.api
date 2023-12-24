<?php

namespace App\Support;

use App\Repositories\Dates\Subscription\Code as Repository;

final class SubscriptionCode
{
    public readonly string $pathDirectory;

    public function __construct(private Repository $repository)
    {
    }

    public function clear(): bool
    {
        try {
            $this->repository->clear();
            return true;
        } catch (\Exception) {
            return false;
        }
    }
}
