<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::create(['name' => 'administrator']);
        $permissions = [
            'users' => Permission::create(['name' => 'users']),
            'clients' => Permission::create(['name' => 'clients']),
        ];
        foreach($permissions as $permission)
            $admin_role->givePermissionTo($permission);

        $franchisee_role = Role::create(['name' => 'franchisee']);
        $franchisee_role->givePermissionTo($permissions['clients']);

        User::find(1)->assignRole($admin_role);
    }
}
