<?php

namespace App\Permissions;

class Data
{
    public static array $roles = [
        'administrator',
        'franchisee_manager',
        'franchisee',
    ];

    public static array $permissions = [
        'users',
        'clients',
    ];

    public static array $roleTranslations = [
        'administrator' => 'Administrador',
        'franchisee_manager' => 'Jefe de Franquicia',
        'franchisee' => 'Franquiciado'
    ];

    public static array $permissionTranslations = [
        'users' => 'Usuarios',
        'clients' => 'Clientes',
    ];
}