<?php

namespace Database\Seeders;

use App\Models\Eloquent\Telegram;
use Illuminate\Database\Seeder;

class TelegramSeeder extends Seeder
{
    public function run(): void
    {
        //$this->create(1, 5, "1370345612", "@mldanshin");
        $this->create(1, 5, "a123fake", "@mldanshin");
        $this->create(2, 5, "b4568fake", "@mldanshin2");
        $this->create(3, 6, "c984fake", null);
        $this->create(4, 13, "d689fake", null);
    }

    private function create(int $id, int $personId, string $telegramId, ?string $telegramUsername): void
    {
        $obj = new Telegram();
        $obj->id = $id;
        $obj->person_id = $personId;
        $obj->telegram_id = $telegramId;
        $obj->telegram_username = $telegramUsername;
        $obj->save();
    }
}
