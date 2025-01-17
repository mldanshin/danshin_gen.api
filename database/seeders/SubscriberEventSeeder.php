<?php

namespace Database\Seeders;

use App\Models\Eloquent\SubscriberEvent;
use Illuminate\Database\Seeder;

class SubscriberEventSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(1, 1, 1);
        $this->create(2, 3, 3);
    }

    private function create(int $id, int $clientId, int $telegramId): void
    {
        $obj = new SubscriberEvent();
        $obj->id = $id;
        $obj->client_id = $clientId;
        $obj->telegram_id = $telegramId;
        $obj->save();
    }
}
