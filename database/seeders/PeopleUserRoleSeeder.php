<?php

namespace Database\Seeders;

use App\Models\Eloquent\PeopleUserRole;
use Illuminate\Database\Seeder;

class PeopleUserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(1, 'admin');
        $this->create(2, 'vip');
        $this->create(3, 'ordinary');
    }

    private function create(int $id, string $slug): void
    {
        $obj = new PeopleUserRole;
        $obj->id = $id;
        $obj->slug = $slug;
        $obj->save();
    }
}
