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

        // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ 
        // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ 
        //
        // DEBES dejar al menos 1 usuario franquiciado (un [User] y un [Franchisee] relacionados) de prueba para generar la 'Guía de ejemplo'
        //
        // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ 
        // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ // /!\ IMPORTANTE /!\ 
        $franchisee_user = User::factory()->create([
            'name' => 'Franquiciado A',
            'email' => 'franquiciado@baratocourier.com',
        ]);
        $franchisee_user->assignRole('franchisee');
        Franchisee::factory()->create([
            'user_id' => $franchisee_user->id
        ]);

        $employee_user = User::factory()->create([
            'name' => 'Empleado',
            'email' => 'empleado@baratocourier.com',
        ]);
        $employee_user->assignRole('employee');
        Employee::create([
            'user_id' => $employee_user->id,
            'franchisee_id' => $franchisee_user->franchisee->id
        ]);

        $franchisee_b_user = User::factory()->create([
            'name' => 'Franquiciado B',
            'email' => 'franquiciado.b@baratocourier.com',
        ]);
        $franchisee_b_user->assignRole('franchisee');
        Franchisee::factory()->create([
            'user_id' => $franchisee_b_user->id,
        ]);
    }

    private function fakeJSONAddress(): string
    {
        return json_encode([]);
    }
}
