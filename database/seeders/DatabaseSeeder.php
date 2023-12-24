<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PersonalAccessTokensSeeder::class,
            GenderSeeder::class,
            MarriageRoleSeeder::class,
            MarriageRoleGenderSeeder::class,
            MarriageRoleScopeSeeder::class,
            ParentRoleSeeder::class,
            ParentRoleGenderSeeder::class,
            PeopleSeeder::class,
            OldSurnameSeeder::class,
            ParentChildSeeder::class,
            MarriageSeeder::class,
            PeopleUserRoleSeeder::class,
            PersonUserRoleSeeder::class,
            PersonUserIdentifierSeeder::class,
            ActivitySeeder::class,
            InternetSeeder::class,
            ResidenceSeeder::class,
            PhoneSeeder::class,
            EmailSeeder::class,
            TelegramSeeder::class,
            PhotoSeeder::class,
            PersonUserSeeder::class,
            PersonUserUnconfirmedSeeder::class,
            SubscriberEventSeeder::class,
            SubscriberCodeSeeder::class
        ]);
    }
}
