<?php

namespace Database\Seeders;

use App\Models\Eloquent\PersonUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PersonUserSeeder extends Seeder
{
    public function run(): void
    {
        $this->create(1, 5, "password1", "token1");
        $this->create(2, 8, "password2", null);
        $this->create(3, 6, "password3", "token3");
        $this->create(4, 14, "password4", "token4");
        $this->create(5, 7, "password5", null);
    }

    private function create(int $id, int $personId, string $password, ?string $rememberToken): void
    {
        $object = new PersonUser();
        $object->id = $id;
        $object->person_id = $personId;
        $object->password = Hash::make($password);
        $object->remember_token = $rememberToken;
        $object->save();
    }
}
