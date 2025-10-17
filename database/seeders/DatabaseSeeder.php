<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@baratocourier.com',
        ]);

        $this->call([
            RolePermissionSeeder::class
        ]);

        $franchisee = User::factory()->create([
            'name' => 'Jefe de Franquicia',
            'email' => 'franquiciado@baratocourier.com',
        ]);

        $franchisee->assignRole('franchisee');
        Franchisee::create([
            'phone_number' => '0999999999',
            'courier_name' => 'CourierA',
            'logo' => null,
            'address' => 'Calle X Avenida Y, Intersección Z, Indiana, CiudadA, Código: 132222',
            'guide_domain' => 'BTC',
            'client_domain' => 'BTA',
            'user_id' => $franchisee->id,
        ]);
    }
}
