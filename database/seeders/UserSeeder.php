<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\User\Employee;
use App\Models\User\Franchisee;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        $employee = User::factory()->create([
            'name' => 'Empleado',
            'email' => 'empleado@baratocourier.com',
        ]);
        Employee::create([
            'user_id' => $employee->id,
            'franchisee_id' => $franchisee->franchisee->id
        ]);
    }
}
