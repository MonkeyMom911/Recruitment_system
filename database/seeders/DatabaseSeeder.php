<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
        'key' => 'logo',
        'value' => 'logos/default.png', // path ke default logo di storage/app/public/logos/
    ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JobVacancySeeder::class,
        ]);
    }
}

// database/seeders/UserSeeder.php

