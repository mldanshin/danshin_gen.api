<?php

namespace Database\Seeders;

use App\Models\Eloquent\PersonUserIdentifier;
use Illuminate\Database\Seeder;

class PersonUserIdentifierSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(1, 'email');
        $this->create(2, 'phone');
    }

    private function create(int $id, string $slug): void
    {
        $obj = new PersonUserIdentifier;
        $obj->id = $id;
        $obj->slug = $slug;
        $obj->save();
    }
}
