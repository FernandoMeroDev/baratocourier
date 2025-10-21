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

        $franchisee_user = User::factory()->create([
            'name' => 'Franquiciado A',
            'email' => 'franquiciado@baratocourier.com',
        ]);
        $franchisee_user->assignRole('franchisee');
        Franchisee::create([
            'phone_number' => '0999999999',
            'courier_name' => 'CourierA',
            'logo' => null,
            'address' => Franchisee::makeJSONAddress(
                'Calle X Avenida Y, Intersección Z',
                'CiudadA',
                'Estado',
                '132222'
            ),
            'guide_domain' => 'BTC',
            'client_domain' => 'BTA',
            'waybill_text_reference' => '1 DE 1 MTC',
            'user_id' => $franchisee_user->id,
            'logo' => 'VqR8UmnaxKxSceFCQ4DOqYR6i1i5bMjQiI3xG15g.webp'
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
        Franchisee::create([
            'phone_number' => '0999999999',
            'courier_name' => 'CourierB',
            'logo' => null,
            'address' => Franchisee::makeJSONAddress(
                'Calle X Avenida Y, Intersección Z',
                'CiudadB',
                'Estado',
                '132222'
            ),
            'guide_domain' => 'TVC',
            'client_domain' => 'VTA',
            'waybill_text_reference' => '1 DE 1 MTC',
            'user_id' => $franchisee_b_user->id,
            'logo' => 'VqR8UmnaxKxSceFCQ4DOqYR6i1i5bMjQiI3xG15g.webp'
        ]);
    }

    private function fakeJSONAddress(): string
    {
        return json_encode([]);
    }
}
