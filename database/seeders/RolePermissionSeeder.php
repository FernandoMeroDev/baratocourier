<?php

namespace Database\Seeders;

use App\Models\User;
use App\Permissions\Data;
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
        User::find(1)->assignRole($admin_role);

        foreach(Data::$permissions as $permission)
            Permission::create(['name' => $permission]);

        $franchisee_role = Role::create(['name' => 'franchisee']);
        $franchisee_role->givePermissionTo('clients');
        $franchisee_role->givePermissionTo('users');

        $franchisee_role = Role::create(['name' => 'employee']);
    }
}
