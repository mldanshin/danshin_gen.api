<?php

namespace Database\Seeders;

use App\Models\Eloquent\SubscriberCode;
use Illuminate\Database\Seeder;

class SubscriberCodeSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(1, 1, "code1", time());
        $this->create(2, 2, "code2", 3456);
        $this->create(3, 4, "code4", 999);
    }

    private function create(int $id, int $clientId, string $code, int $time): void
    {
        $obj = new SubscriberCode();
        $obj->id = $id;
        $obj->client_id = $clientId;
        $obj->code = $code;
        $obj->time = $time;
        $obj->save();
    }
}
