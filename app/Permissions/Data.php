<?php

namespace App\Permissions;

class Data
{
    public static array $roles = [
        'administrator',
        'franchisee',
        'employee',
    ];

    public static array $permissions = [
        'users',
        'clients',
        'packages'
    ];

    public static array $roleTranslations = [
        'administrator' => 'Administrador',
        'franchisee' => 'Franquiciado',
        'employee' => 'Empleado'
    ];

    public static array $permissionTranslations = [
        'users' => 'Usuarios',
        'clients' => 'Clientes',
        'packages' => 'Paquetes'
    ];
}