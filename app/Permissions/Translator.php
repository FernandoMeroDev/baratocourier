<?php

namespace App\Permissions;

class Translator
{
    private static array $roles = [
        'administrator' => 'Administrador',
        'franchisee' => 'Franquiciado'
    ];

    private static array $permissions = [
        'users' => 'Usuarios',
        'clients' => 'Clientes',
    ];

    public static function role(string $role): string
    {
        return static::$roles[$role];
    }
}