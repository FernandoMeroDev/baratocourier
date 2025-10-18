<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use App\Models\User\Franchisee;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class
        ]);

        Client::factory(count: 20)->create();
    }
}
