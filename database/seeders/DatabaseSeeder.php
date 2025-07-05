<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\MenusTableSeederl;
use Database\Seeders\AccessesTableSeeder;
use Database\Seeders\StoresTableSeeder;
use Database\Seeders\LeadsTableSeeder;
use Database\Seeders\ActivitiesTableSeeder;
use Database\Seeders\LogActivitySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UsersTableSeeder::class,
            // StoresTableSeeder::class,
            // LeadsTableSeeder::class,
            // ActivitiesTableSeeder::class,
            // LogActivitySeeder::class,
        ]);
    }
}
