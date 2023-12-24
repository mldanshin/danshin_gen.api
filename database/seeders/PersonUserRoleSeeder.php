<?php

namespace Database\Seeders;

use App\Models\Eloquent\PersonUserRole;
use Illuminate\Database\Seeder;

class PersonUserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(5, 1);
        $this->create(6, 3);
        $this->create(7, 2);
    }

    private function create(int $person, int $role): void
    {
        PersonUserRole::create([
            "person_id" => $person,
            "role_id" => $role,
        ]);
    }
}
