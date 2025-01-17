<?php

namespace Database\Seeders;

use App\Models\Eloquent\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(1, "DMEPMMSNSJNWSU");
        $this->create(2, "SASDSDWWDWWEWE");
        $this->create(3, "DSDCQSQQCWODSD");
        $this->create(4, "DSWEWEDLPPOKKP");
        $this->create(5, "DSDWWDWOIJOIJW");
    }

    private function create(int $id, string $uid): void
    {
        $object = new Client();
        $object->id = $id;
        $object->uid = $uid;
        $object->save();
    }
}
